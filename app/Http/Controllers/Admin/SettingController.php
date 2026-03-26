<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\XSenderService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show WhatsApp API settings form.
     */
    public function whatsapp()
    {
        $xsender = new XSenderService();

        $settings = [
            'wa_enabled' => Setting::get('wa_enabled', '0'),
            'wa_api_key' => Setting::get('wa_api_key', ''),
            'wa_sender' => Setting::get('wa_sender', ''),
            'wa_endpoint' => Setting::get('wa_endpoint', 'https://xsender.id/id/send-message'),
            'wa_template' => Setting::get('wa_template', $xsender->defaultTemplate()),
        ];

        return view('admin.settings.whatsapp', compact('settings'));
    }

    /**
     * Save WhatsApp API settings.
     */
    public function updateWhatsapp(Request $request)
    {
        $request->validate([
            'wa_api_key' => 'nullable|string|max:500',
            'wa_sender' => 'nullable|string|max:20',
            'wa_endpoint' => 'nullable|url|max:500',
            'wa_template' => 'nullable|string|max:5000',
        ]);

        Setting::set('wa_enabled', $request->has('wa_enabled') ? '1' : '0');
        Setting::set('wa_api_key', $request->wa_api_key);
        Setting::set('wa_sender', $request->wa_sender);
        Setting::set('wa_endpoint', $request->wa_endpoint ?: 'https://xsender.id/id/send-message');
        Setting::set('wa_template', $request->wa_template);

        return redirect()->route('admin.settings.whatsapp')
            ->with('success', 'Pengaturan WhatsApp berhasil disimpan.');
    }

    /**
     * Send a test WhatsApp message.
     */
    public function testWhatsapp(Request $request)
    {
        $request->validate([
            'test_number' => 'required|string|max:20',
        ]);

        $xsender = new XSenderService();

        if (!$xsender->isEnabled()) {
            return redirect()->route('admin.settings.whatsapp')
                ->with('error', 'WhatsApp API belum aktif. Aktifkan dan isi API Key & Sender terlebih dahulu.');
        }

        $result = $xsender->send(
            $request->test_number,
            "✅ *Test Message dari Mawkost*\n\nIni adalah pesan test dari sistem Mawkost.\nWhatsApp API sudah terhubung dengan benar! 🎉"
        );

        if ($result['ok']) {
            return redirect()->route('admin.settings.whatsapp')
                ->with('success', 'Pesan test berhasil dikirim ke ' . $request->test_number);
        }

        return redirect()->route('admin.settings.whatsapp')
            ->with('error', 'Gagal mengirim pesan test: ' . ($result['body'] ?? 'Unknown error'));
    }
}
