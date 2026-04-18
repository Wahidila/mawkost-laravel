<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Setting;
use App\Services\AiChatService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController extends Controller
{
    /**
     * Show the AI consultation page.
     */
    public function index()
    {
        $aiEnabled = Setting::get('ai_enabled', '0') === '1';

        return view('chat.index', compact('aiEnabled'));
    }

    /**
     * API: Send a message and get message ID for streaming.
     */
    public function send(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string|max:64',
            'message' => 'required|string|max:2000',
        ]);

        $aiService = new AiChatService();

        if (!$aiService->isEnabled()) {
            return response()->json([
                'error' => 'Fitur AI Konsultasi sedang tidak aktif. Silakan coba lagi nanti.',
            ], 503);
        }

        // Save user message
        $userMessage = ChatMessage::create([
            'session_id' => $request->session_id,
            'role' => 'user',
            'content' => $request->message,
        ]);

        return response()->json([
            'message_id' => $userMessage->id,
            'session_id' => $request->session_id,
        ]);
    }

    /**
     * API: Stream AI response via Server-Sent Events.
     */
    public function stream(Request $request, $messageId)
    {
        $userMessage = ChatMessage::findOrFail($messageId);
        $sessionId = $userMessage->session_id;

        $aiService = new AiChatService();

        if (!$aiService->isEnabled()) {
            return response()->json([
                'error' => 'Fitur AI Konsultasi sedang tidak aktif.',
            ], 503);
        }

        // Get conversation history for context
        $history = ChatMessage::getConversationHistory($sessionId, 20);

        return new StreamedResponse(function () use ($aiService, $history, $sessionId) {
            // Disable output buffering
            if (ob_get_level()) {
                ob_end_clean();
            }

            $fullResponse = '';

            try {
                foreach ($aiService->streamChat($history) as $chunk) {
                    $fullResponse .= $chunk;

                    // Send SSE event
                    echo "data: " . json_encode(['content' => $chunk]) . "\n\n";

                    if (ob_get_level()) {
                        ob_flush();
                    }
                    flush();
                }

                // Send done event
                echo "data: [DONE]\n\n";
                if (ob_get_level()) {
                    ob_flush();
                }
                flush();

                // Sanitize and save the complete AI response to database
                $cleanResponse = AiChatService::sanitizeContent($fullResponse);
                if (!empty($cleanResponse)) {
                    ChatMessage::create([
                        'session_id' => $sessionId,
                        'role' => 'assistant',
                        'content' => $cleanResponse,
                    ]);
                }

            } catch (\Exception $e) {
                $errorMsg = 'Maaf, terjadi kesalahan. Silakan coba lagi.';
                echo "data: " . json_encode(['content' => $errorMsg, 'error' => true]) . "\n\n";
                echo "data: [DONE]\n\n";
                if (ob_get_level()) {
                    ob_flush();
                }
                flush();

                // Save error response
                ChatMessage::create([
                    'session_id' => $sessionId,
                    'role' => 'assistant',
                    'content' => $errorMsg,
                ]);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // Disable nginx buffering
        ]);
    }

    /**
     * API: Get chat history for a session.
     */
    public function history(Request $request, $sessionId)
    {
        $messages = ChatMessage::bySession($sessionId)
            ->orderBy('created_at', 'asc')
            ->take(50)
            ->get()
            ->map(fn($msg) => [
                'id' => $msg->id,
                'role' => $msg->role,
                'content' => $msg->role === 'assistant'
                    ? AiChatService::sanitizeContent($msg->content)
                    : $msg->content,
                'created_at' => $msg->created_at->toISOString(),
            ]);

        return response()->json([
            'messages' => $messages,
        ]);
    }
}
