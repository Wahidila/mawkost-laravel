<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $model;
    protected int $maxTokens;
    protected float $temperature;
    protected string $customSystemPrompt;
    protected KostKnowledgeService $knowledgeService;

    public function __construct()
    {
        $this->apiKey = Setting::get('ai_api_key', '');
        $this->baseUrl = rtrim(Setting::get('ai_base_url', 'https://api.openai.com/v1'), '/');
        $this->model = Setting::get('ai_model', 'gpt-4o-mini');
        $this->maxTokens = (int) Setting::get('ai_max_tokens', '1024');
        $this->temperature = (float) Setting::get('ai_temperature', '0.7');
        $this->customSystemPrompt = Setting::get('ai_system_prompt', '');
        $this->knowledgeService = new KostKnowledgeService();
    }

    /**
     * Check if AI chat is enabled and configured.
     */
    public function isEnabled(): bool
    {
        return Setting::get('ai_enabled', '0') === '1'
            && !empty($this->apiKey)
            && !empty($this->baseUrl)
            && !empty($this->model);
    }

    /**
     * Build the full system prompt with kost knowledge.
     */
    public function buildSystemPrompt(): string
    {
        $knowledgeBase = $this->knowledgeService->buildKnowledgeBase();

        $basePrompt = <<<PROMPT
Kamu Asisten AI Mawkost — konsultan kost ramah di mawkost.id. Jawab dalam Bahasa Indonesia, ringkas, dan personal.

ATURAN:
1. HANYA rekomendasikan kost dari data di bawah. JANGAN mengarang.
2. Maks 3 rekomendasi per jawaban kecuali user minta lebih.
3. JANGAN berikan alamat lengkap kost — itu informasi berbayar. Hanya sebutkan area/wilayah.
4. JANGAN berikan kontak pemilik — itu informasi berbayar (perlu unlock di halaman detail).
5. Jika tidak cocok, sarankan alternatif atau minta user perluas kriteria.
6. Di luar topik kost, arahkan kembali dengan sopan.

CARA KERJA MAWKOST: Cari & bandingkan → Pilih kost → Bayar unlock → Dapat kontak pemilik → Booking langsung.

FORMAT REKOMENDASI:
**🏠 Nama Kost** (MK-XXX)
📍 Kota, Area | 💰 Rp X.XXX.XXX/bln | 🏷️ Tipe
✨ Fasilitas utama
🔗 [Lihat Detail](URL)

DATA KOST FORMAT: CSV dengan pemisah |
Kolom: KODE|NAMA|KOTA|TIPE|HARGA_RB(dalam ribuan, 800=Rp800.000)|AREA|PARKIR|FASILITAS|DEKAT|LABEL|URL

PROMPT;

        // Append custom system prompt if set
        if (!empty($this->customSystemPrompt)) {
            $basePrompt .= "\n\n## INSTRUKSI TAMBAHAN DARI ADMIN\n" . $this->customSystemPrompt;
        }

        // Append knowledge base
        $basePrompt .= "\n\n" . $knowledgeBase;

        return $basePrompt;
    }

    /**
     * Send chat request with streaming to AI provider.
     * Returns a Generator that yields content chunks.
     * Automatically strips <think>...</think> blocks from reasoning models.
     *
     * @param array $messages Array of ['role' => 'user|assistant', 'content' => '...']
     * @return \Generator
     */
    public function streamChat(array $messages): \Generator
    {
        $systemPrompt = $this->buildSystemPrompt();

        // Prepend system message
        $fullMessages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $messages
        );

        $url = $this->baseUrl . '/chat/completions';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'text/event-stream',
            ])
            ->withOptions([
                'stream' => true,
                'timeout' => 120,
                'connect_timeout' => 10,
            ])
            ->post($url, [
                'model' => $this->model,
                'messages' => $fullMessages,
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
                'stream' => true,
            ]);

            if ($response->failed()) {
                $errorBody = $response->body();
                Log::error('AI Chat API error', [
                    'status' => $response->status(),
                    'body' => $errorBody,
                ]);
                yield 'Maaf, terjadi kesalahan saat menghubungi AI. Silakan coba lagi nanti.';
                return;
            }

            $body = $response->toPsrResponse()->getBody();
            $buffer = '';

            // Think-block tracking: buffer content while inside <think> tags
            $insideThink = false;
            $thinkBuffer = '';
            $contentStarted = false;

            while (!$body->eof()) {
                $chunk = $body->read(1024);
                $buffer .= $chunk;

                // Process complete SSE lines
                while (($newlinePos = strpos($buffer, "\n")) !== false) {
                    $line = substr($buffer, 0, $newlinePos);
                    $buffer = substr($buffer, $newlinePos + 1);

                    $line = trim($line);

                    if (empty($line)) {
                        continue;
                    }

                    // SSE format: "data: {...}"
                    if (strpos($line, 'data: ') !== 0) {
                        continue;
                    }

                    $data = substr($line, 6); // Remove "data: " prefix

                    if ($data === '[DONE]') {
                        return;
                    }

                    $json = json_decode($data, true);
                    if (!$json) {
                        continue;
                    }

                    $content = $json['choices'][0]['delta']['content'] ?? '';
                    if ($content === '') {
                        continue;
                    }

                    // --- Think-block filtering ---
                    // Process the content through think-block filter
                    $filtered = $this->filterThinkChunk($content, $insideThink, $thinkBuffer, $contentStarted);
                    if ($filtered !== '') {
                        yield $filtered;
                    }
                }
            }

            // Process remaining buffer
            if (!empty(trim($buffer))) {
                $line = trim($buffer);
                if (strpos($line, 'data: ') === 0) {
                    $data = substr($line, 6);
                    if ($data !== '[DONE]') {
                        $json = json_decode($data, true);
                        if ($json) {
                            $content = $json['choices'][0]['delta']['content'] ?? '';
                            if ($content !== '') {
                                $filtered = $this->filterThinkChunk($content, $insideThink, $thinkBuffer, $contentStarted);
                                if ($filtered !== '') {
                                    yield $filtered;
                                }
                            }
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            Log::error('AI Chat stream error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            yield 'Maaf, terjadi kesalahan koneksi ke AI. Silakan coba lagi nanti.';
        }
    }

    /**
     * Filter a streaming chunk to strip <think>...</think> blocks.
     * Uses pass-by-reference state variables to track across chunks.
     */
    protected function filterThinkChunk(string $chunk, bool &$insideThink, string &$thinkBuffer, bool &$contentStarted): string
    {
        $output = '';
        $thinkBuffer .= $chunk;

        // If we haven't started real content yet, check for <think> at the beginning
        if (!$contentStarted) {
            $trimmed = ltrim($thinkBuffer);

            // Check if it starts with <think> (possibly still accumulating)
            if (str_starts_with($trimmed, '<think>')) {
                $insideThink = true;
            } elseif (str_starts_with($trimmed, '<') && str_starts_with('<think>', $trimmed)) {
                // Partial match — still accumulating, wait for more
                return '';
            } elseif (str_starts_with($trimmed, '<think')) {
                // Partial <think tag, wait for more
                return '';
            }
        }

        if ($insideThink) {
            // Look for closing </think> tag
            $closePos = strpos($thinkBuffer, '</think>');
            if ($closePos !== false) {
                // Found the end — discard everything up to and including </think>
                $afterThink = substr($thinkBuffer, $closePos + 8); // 8 = strlen('</think>')
                $thinkBuffer = '';
                $insideThink = false;
                $contentStarted = true;

                // Clean up leading whitespace after think block
                $afterThink = ltrim($afterThink, "\n\r");

                if ($afterThink !== '') {
                    $output = $this->sanitizeChunk($afterThink);
                }
            }
            // Still inside think block — don't output anything
            return $output;
        }

        // Not inside think block — output the content
        $contentStarted = true;
        $result = $this->sanitizeChunk($thinkBuffer);
        $thinkBuffer = '';
        return $result;
    }

    /**
     * Sanitize a single chunk of AI output.
     * Strips CJK characters and other unwanted artifacts.
     */
    protected function sanitizeChunk(string $text): string
    {
        // Remove CJK Unified Ideographs and related blocks (Chinese/Japanese/Korean characters)
        // These sometimes leak from reasoning models' internal chain-of-thought
        $text = preg_replace('/[\x{4E00}-\x{9FFF}]/u', '', $text);       // CJK Unified Ideographs
        $text = preg_replace('/[\x{3400}-\x{4DBF}]/u', '', $text);       // CJK Extension A
        $text = preg_replace('/[\x{3000}-\x{303F}]/u', '', $text);       // CJK Symbols and Punctuation
        $text = preg_replace('/[\x{FF00}-\x{FFEF}]/u', '', $text);       // Fullwidth Forms
        $text = preg_replace('/[\x{2E80}-\x{2EFF}]/u', '', $text);       // CJK Radicals Supplement
        $text = preg_replace('/[\x{31C0}-\x{31EF}]/u', '', $text);       // CJK Strokes
        $text = preg_replace('/[\x{2FF0}-\x{2FFF}]/u', '', $text);       // Ideographic Description Characters

        return $text;
    }

    /**
     * Sanitize a complete AI response text.
     * Strips <think> blocks, CJK characters, and normalizes whitespace.
     */
    public static function sanitizeContent(string $text): string
    {
        // 1. Strip <think>...</think> blocks (including multiline, greedy)
        $text = preg_replace('/<think>[\s\S]*?<\/think>/i', '', $text);

        // 2. Strip any orphaned <think> or </think> tags
        $text = preg_replace('/<\/?think>/i', '', $text);

        // 3. Remove CJK characters
        $text = preg_replace('/[\x{4E00}-\x{9FFF}]/u', '', $text);
        $text = preg_replace('/[\x{3400}-\x{4DBF}]/u', '', $text);
        $text = preg_replace('/[\x{3000}-\x{303F}]/u', '', $text);
        $text = preg_replace('/[\x{FF00}-\x{FFEF}]/u', '', $text);
        $text = preg_replace('/[\x{2E80}-\x{2EFF}]/u', '', $text);
        $text = preg_replace('/[\x{31C0}-\x{31EF}]/u', '', $text);
        $text = preg_replace('/[\x{2FF0}-\x{2FFF}]/u', '', $text);

        // 4. Normalize excessive newlines (max 2 consecutive)
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        // 5. Trim leading/trailing whitespace
        $text = trim($text);

        return $text;
    }

    /**
     * Send a non-streaming chat request (for testing).
     */
    public function chat(array $messages): ?string
    {
        $systemPrompt = $this->buildSystemPrompt();

        $fullMessages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $messages
        );

        $url = $this->baseUrl . '/chat/completions';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout(60)
            ->post($url, [
                'model' => $this->model,
                'messages' => $fullMessages,
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
                'stream' => false,
            ]);

            if ($response->failed()) {
                Log::error('AI Chat API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();
            return $data['choices'][0]['message']['content'] ?? null;

        } catch (\Exception $e) {
            Log::error('AI Chat error', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Test connection to AI provider.
     */
    public function testConnection(): array
    {
        $url = $this->baseUrl . '/chat/completions';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout(15)
            ->post($url, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => 'Halo, balas dengan "Koneksi berhasil!" saja.'],
                ],
                'max_tokens' => 20,
                'temperature' => 0,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'No response';
                $model = $data['model'] ?? $this->model;
                return [
                    'ok' => true,
                    'reply' => $reply,
                    'model' => $model,
                ];
            }

            return [
                'ok' => false,
                'error' => 'HTTP ' . $response->status() . ': ' . $response->body(),
            ];

        } catch (\Exception $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
