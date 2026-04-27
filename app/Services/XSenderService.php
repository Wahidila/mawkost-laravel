<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XSenderService
{
    protected string $apiKey;
    protected string $sender;
    protected string $endpoint;

    public function __construct()
    {
        // Priority: DB settings → config/services.php → .env
        $this->apiKey = (string)(Setting::get('wa_api_key') ?? config('services.xsender.api_key') ?? '');
        $this->sender = (string)(Setting::get('wa_sender') ?? config('services.xsender.sender') ?? '');
        $this->endpoint = (string)(Setting::get('wa_endpoint') ?? config('services.xsender.endpoint') ?? 'https://xsender.id/id/send-message');
    }

    /**
     * Check if WhatsApp sending is enabled and configured.
     */
    public function isEnabled(): bool
    {
        $enabled = Setting::get('wa_enabled', '0');
        return $enabled === '1' && !empty($this->apiKey) && !empty($this->sender);
    }

    /**
     * Format phone number to international format (628xxx).
     */
    public function formatPhone(string $phone): string
    {
        // Remove spaces, dashes, and other chars
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Convert 08xxx to 628xxx
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // Add 62 prefix if not present
        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Send a raw WhatsApp message.
     */
    public function send(string $phone, string $message): array
    {
        if (!$this->isEnabled()) {
            return [
                'ok' => false,
                'status' => 0,
                'body' => 'WhatsApp API tidak aktif atau belum dikonfigurasi.',
            ];
        }

        try {
            $response = Http::asForm()->post($this->endpoint, [
                'api_key' => $this->apiKey,
                'sender' => $this->sender,
                'number' => $this->formatPhone($phone),
                'message' => $message,
            ]);

            return [
                'ok' => $response->successful(),
                'status' => $response->status(),
                'body' => $response->body(),
            ];
        }
        catch (\Exception $e) {
            Log::error('XSender send failed: ' . $e->getMessage());
            return [
                'ok' => false,
                'status' => 0,
                'body' => $e->getMessage(),
            ];
        }
    }

    /**
     * Build kost notification message from an order.
     */
    public function buildKostMessage(Order $order): string
    {
        $order->loadMissing(['kost.city', 'kost.facilities']);

        $kost = $order->kost;

        // Get custom template or use default
        $template = Setting::get('wa_template', $this->defaultTemplate());

        // Build facility list
        $facilities = '';
        if ($kost->facilities && $kost->facilities->count() > 0) {
            $facilities = $kost->facilities->pluck('name')->implode(', ');
        }

        // Replace placeholders
        $replacements = [
            '{customer_name}' => $order->customer_name,
            '{invoice_no}' => $order->invoice_no,
            '{kost_title}' => $kost->title,
            '{kost_name}' => $kost->name,
            '{kost_code}' => $kost->kode ?? '-',
            '{kost_type}' => ucfirst($kost->type),
            '{kost_price}' => 'Rp ' . number_format($kost->price, 0, ',', '.'),
            '{kost_address}' => $kost->address ?? '-',
            '{kost_city}' => $kost->city->name ?? '-',
            '{kost_area}' => $kost->area_label ?? '-',
            '{owner_name}' => $kost->owner_name ?? '-',
            '{owner_contact}' => $kost->owner_contact ?? '-',
            '{maps_link}' => $kost->maps_link ?? '-',
            '{facilities}' => $facilities ?: '-',
            '{amount}' => 'Rp ' . number_format($order->amount, 0, ',', '.'),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    /**
     * Send kost notification to a customer after checkout.
     */
    public function sendKostNotification(Order $order): array
    {
        $message = $this->buildKostMessage($order);
        return $this->send($order->customer_whatsapp, $message);
    }

    /**
     * Default message template.
     */
    public function defaultTemplate(): string
    {
        return <<<'MSG'
✅ *Pembayaran Berhasil!*

Halo *{customer_name}*, terima kasih telah melakukan pembelian di Mawkost.

📋 *Detail Pesanan*
No. Invoice: {invoice_no}
Jumlah Bayar: {amount}

🏠 *Detail Kost*
Nama: {kost_name}
Kode: {kost_code}
Tipe: {kost_type}
Harga: {kost_price}/bulan
Alamat: {kost_address}
Kota: {kost_city}
Area: {kost_area}
👤 *Pemilik Kost*
Nama: {owner_name}
Kontak: {owner_contact}

📍 *Google Maps*
{maps_link}

🏷️ *Fasilitas*
{facilities}

Terima kasih telah menggunakan Mawkost! 🙏
MSG;
    }
}
