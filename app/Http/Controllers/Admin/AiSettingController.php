<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\AiChatService;
use App\Services\KostKnowledgeService;
use Illuminate\Http\Request;

class AiSettingController extends Controller
{
    /**
     * Show AI settings form.
     */
    public function show()
    {
        $settings = [
            'ai_enabled' => Setting::get('ai_enabled', '0'),
            'ai_api_key' => Setting::get('ai_api_key', ''),
            'ai_base_url' => Setting::get('ai_base_url', 'https://api.openai.com/v1'),
            'ai_model' => Setting::get('ai_model', 'gpt-4o-mini'),
            'ai_system_prompt' => Setting::get('ai_system_prompt', ''),
            'ai_max_tokens' => Setting::get('ai_max_tokens', '1024'),
            'ai_temperature' => Setting::get('ai_temperature', '0.7'),
        ];

        // Get knowledge base stats
        $knowledgeService = new KostKnowledgeService();
        $summary = $knowledgeService->getKostSummary();

        return view('admin.settings.ai', compact('settings', 'summary'));
    }

    /**
     * Save AI settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'ai_api_key' => 'nullable|string|max:500',
            'ai_base_url' => 'nullable|url|max:500',
            'ai_model' => 'nullable|string|max:100',
            'ai_system_prompt' => 'nullable|string|max:5000',
            'ai_max_tokens' => 'nullable|integer|min:100|max:16000',
            'ai_temperature' => 'nullable|numeric|min:0|max:2',
        ]);

        Setting::set('ai_enabled', $request->has('ai_enabled') ? '1' : '0');
        Setting::set('ai_api_key', $request->ai_api_key);
        Setting::set('ai_base_url', $request->ai_base_url ?: 'https://api.openai.com/v1');
        Setting::set('ai_model', $request->ai_model ?: 'gpt-4o-mini');
        Setting::set('ai_system_prompt', $request->ai_system_prompt);
        Setting::set('ai_max_tokens', $request->ai_max_tokens ?: '1024');
        Setting::set('ai_temperature', $request->ai_temperature ?: '0.7');

        // Clear knowledge cache so it rebuilds with fresh data
        $knowledgeService = new KostKnowledgeService();
        $knowledgeService->clearCache();

        return redirect()->route('admin.settings.ai')
            ->with('success', 'Pengaturan AI berhasil disimpan.');
    }

    /**
     * Test AI connection.
     */
    public function test()
    {
        $aiService = new AiChatService();

        if (empty(Setting::get('ai_api_key'))) {
            return redirect()->route('admin.settings.ai')
                ->with('error', 'API Key belum diisi.');
        }

        $result = $aiService->testConnection();

        if ($result['ok']) {
            return redirect()->route('admin.settings.ai')
                ->with('success', 'Koneksi berhasil! Model: ' . $result['model'] . ' — Respons: "' . $result['reply'] . '"');
        }

        return redirect()->route('admin.settings.ai')
            ->with('error', 'Gagal terhubung ke AI: ' . ($result['error'] ?? 'Unknown error'));
    }

    /**
     * Clear knowledge base cache.
     */
    public function clearCache()
    {
        $knowledgeService = new KostKnowledgeService();
        $knowledgeService->clearCache();

        return redirect()->route('admin.settings.ai')
            ->with('success', 'Cache knowledge base berhasil dihapus. Data akan diperbarui dari database pada request berikutnya.');
    }
}
