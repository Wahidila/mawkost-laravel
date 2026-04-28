<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\WatermarkService;
use App\Services\XSenderService;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    // =========================================================================
    // Xendit Payment Gateway Settings
    // =========================================================================

    /**
     * Show Xendit payment gateway settings form.
     */
    public function xendit()
    {
        $settings = [
            'xendit_enabled' => Setting::get('xendit_enabled', '0'),
            'xendit_secret_key' => Setting::get('xendit_secret_key', ''),
            'xendit_webhook_token' => Setting::get('xendit_webhook_token', ''),
            'xendit_is_production' => Setting::get('xendit_is_production', '0'),
            'xendit_invoice_duration' => Setting::get('xendit_invoice_duration', '24'),
        ];

        return view('admin.settings.xendit', compact('settings'));
    }

    /**
     * Save Xendit payment gateway settings.
     */
    public function updateXendit(Request $request)
    {
        $request->validate([
            'xendit_secret_key' => 'nullable|string|max:500',
            'xendit_webhook_token' => 'nullable|string|max:500',
            'xendit_is_production' => 'required|in:0,1',
            'xendit_invoice_duration' => 'nullable|integer|min:1|max:720',
        ]);

        Setting::set('xendit_enabled', $request->has('xendit_enabled') ? '1' : '0');
        Setting::set('xendit_secret_key', $request->xendit_secret_key);
        Setting::set('xendit_webhook_token', $request->xendit_webhook_token);
        Setting::set('xendit_is_production', $request->xendit_is_production);
        Setting::set('xendit_invoice_duration', $request->xendit_invoice_duration ?: '24');

        return redirect()->route('admin.settings.xendit')
            ->with('success', 'Pengaturan Xendit berhasil disimpan.');
    }

    /**
     * Test Xendit API connection.
     */
    public function testXendit()
    {
        $xendit = new XenditService();

        if (empty(Setting::get('xendit_secret_key'))) {
            return redirect()->route('admin.settings.xendit')
                ->with('error', 'Secret API Key belum diisi.');
        }

        $result = $xendit->testConnection();

        if ($result['ok']) {
            $balance = number_format($result['balance'], 0, ',', '.');
            return redirect()->route('admin.settings.xendit')
                ->with('success', '✅ Koneksi berhasil! Saldo akun Xendit: Rp ' . $balance);
        }

        return redirect()->route('admin.settings.xendit')
            ->with('error', 'Gagal terhubung ke Xendit: ' . ($result['error'] ?? 'Unknown error'));
    }

    // =========================================================================
    // Footer Links Settings
    // =========================================================================

    /**
     * Show Footer links settings form.
     */
    public function footer()
    {
        $defaultKota = json_encode([
            ['label' => 'Malang', 'url' => '/kost/malang'],
            ['label' => 'Surabaya', 'url' => '/kost/surabaya'],
            ['label' => 'Yogyakarta', 'url' => '/kost/yogyakarta'],
            ['label' => 'Bali', 'url' => '/kost/bali'],
        ]);
        $defaultLayanan = json_encode([
            ['label' => 'Cariin Kost', 'url' => '/cari-kost'],
            ['label' => 'Survey Kost', 'url' => '/#cara-kerja'],
            ['label' => 'Promosi Kost', 'url' => '/kontak'],
            ['label' => 'Info Kost', 'url' => '/cari-kost'],
        ]);
        $defaultKontak = json_encode([
            ['label' => 'maw.kost198@gmail.com', 'url' => 'mailto:maw.kost198@gmail.com'],
            ['label' => '+62 823-3798-5404', 'url' => 'tel:+6282337985404'],
            ['label' => '@maw.kost', 'url' => '#'],
        ]);

        $defaultSosmed = json_encode([
            ['platform' => 'tiktok', 'url' => '#'],
            ['platform' => 'instagram', 'url' => '#'],
            ['platform' => 'whatsapp', 'url' => '#'],
        ]);

        $footerKota = json_decode(Setting::get('footer_kota', $defaultKota), true) ?: [];
        $footerLayanan = json_decode(Setting::get('footer_layanan', $defaultLayanan), true) ?: [];
        $footerKontak = json_decode(Setting::get('footer_kontak', $defaultKontak), true) ?: [];
        $footerSosmed = json_decode(Setting::get('footer_sosmed', $defaultSosmed), true) ?: [];

        return view('admin.settings.footer', compact('footerKota', 'footerLayanan', 'footerKontak', 'footerSosmed'));
    }

    // =========================================================================
    // Watermark Settings
    // =========================================================================

    /**
     * Show Watermark settings form.
     */
    public function watermark()
    {
        $settings = [
            'watermark_enabled' => Setting::get('watermark_enabled', '0'),
            'watermark_image' => Setting::get('watermark_image', ''),
            'watermark_opacity' => Setting::get('watermark_opacity', '50'),
            'watermark_size' => Setting::get('watermark_size', '30'),
        ];

        return view('admin.settings.watermark', compact('settings'));
    }

    /**
     * Save Watermark settings.
     */
    public function updateWatermark(Request $request)
    {
        $request->validate([
            'watermark_image' => 'nullable|image|mimes:png,webp|max:2048',
            'watermark_opacity' => 'required|integer|min:0|max:100',
            'watermark_size' => 'required|integer|min:10|max:80',
        ]);

        Setting::set('watermark_enabled', $request->has('watermark_enabled') ? '1' : '0');
        Setting::set('watermark_opacity', $request->watermark_opacity);
        Setting::set('watermark_size', $request->watermark_size);

        // Handle watermark image upload
        if ($request->hasFile('watermark_image')) {
            // Delete old watermark image if exists
            $oldImage = Setting::get('watermark_image');
            if ($oldImage) {
                $oldDiskPath = str_replace('storage/', '', $oldImage);
                Storage::disk('public')->delete($oldDiskPath);
            }

            $path = $request->file('watermark_image')->store('watermarks', 'public');
            Setting::set('watermark_image', 'storage/' . $path);
        }

        // Handle watermark image removal
        if ($request->has('remove_watermark_image')) {
            $oldImage = Setting::get('watermark_image');
            if ($oldImage) {
                $oldDiskPath = str_replace('storage/', '', $oldImage);
                Storage::disk('public')->delete($oldDiskPath);
            }
            Setting::set('watermark_image', '');
        }

        WatermarkService::bumpVersion();

        return redirect()->route('admin.settings.watermark')
            ->with('success', 'Pengaturan watermark berhasil disimpan.');
    }

    public function watermarkImageIds(WatermarkService $watermarkService)
    {
        if (!$watermarkService->isEnabled()) {
            return response()->json(['error' => 'Watermark belum aktif atau gambar belum diupload.'], 422);
        }

        $ids = $watermarkService->getUploadedImageIds();

        return response()->json(['ids' => $ids, 'total' => count($ids)]);
    }

    public function watermarkApplyBatch(Request $request, WatermarkService $watermarkService)
    {
        if (!$watermarkService->isEnabled()) {
            return response()->json(['error' => 'Watermark tidak aktif.'], 422);
        }

        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);

        $result = $watermarkService->applyBatch($request->ids);

        WatermarkService::bumpVersion();

        return response()->json($result);
    }

    /**
     * Save Footer links settings.
     */
    public function updateFooter(Request $request)
    {
        $kota = collect($request->input('kota', []))->values()->map(fn($item) => [
        'label' => $item['label'] ?? '',
        'url' => $item['url'] ?? '#',
        ])->filter(fn($item) => !empty($item['label']))->values()->toArray();

        $layanan = collect($request->input('layanan', []))->values()->map(fn($item) => [
        'label' => $item['label'] ?? '',
        'url' => $item['url'] ?? '#',
        ])->filter(fn($item) => !empty($item['label']))->values()->toArray();

        $kontak = collect($request->input('kontak', []))->values()->map(fn($item) => [
        'label' => $item['label'] ?? '',
        'url' => $item['url'] ?? '#',
        ])->filter(fn($item) => !empty($item['label']))->values()->toArray();

        $sosmed = collect($request->input('sosmed', []))->values()->map(fn($item) => [
        'platform' => $item['platform'] ?? '',
        'url' => $item['url'] ?? '#',
        ])->filter(fn($item) => !empty($item['platform']))->values()->toArray();

        Setting::set('footer_kota', json_encode($kota));
        Setting::set('footer_layanan', json_encode($layanan));
        Setting::set('footer_kontak', json_encode($kontak));
        Setting::set('footer_sosmed', json_encode($sosmed));

        return redirect()->route('admin.settings.footer')
            ->with('success', 'Pengaturan footer berhasil disimpan.');
    }

    public function alerts()
    {
        $settings = [
            'kost_alerts_enabled' => Setting::get('kost_alerts_enabled', '0'),
        ];

        $stats = [
            'total_alerts' => \App\Models\KostAlert::count(),
            'active_alerts' => \App\Models\KostAlert::where('is_active', true)->count(),
            'users_with_alerts' => \App\Models\KostAlert::distinct('user_id')->count('user_id'),
            'pending_kosts' => \App\Models\Kost::whereNull('notified_at')->count(),
        ];

        return view('admin.settings.alerts', compact('settings', 'stats'));
    }

    public function updateAlerts(Request $request)
    {
        Setting::set('kost_alerts_enabled', $request->has('kost_alerts_enabled') ? '1' : '0');

        return redirect()->route('admin.settings.alerts')
            ->with('success', 'Pengaturan alert berhasil disimpan.');
    }

    public function testAlert(Request $request)
    {
        $request->validate([
            'channel' => 'required|in:email,whatsapp',
            'target' => 'required|string|max:255',
        ]);

        $service = new \App\Services\KostAlertService();
        $result = $service->sendTestNotification($request->channel, $request->target);

        return redirect()->route('admin.settings.alerts')
            ->with($result['ok'] ? 'success' : 'error', $result['message']);
    }
}
