<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XenditService
{
    protected string $secretKey;
    protected string $webhookToken;
    protected bool $isProduction;
    protected int $invoiceDuration;

    public function __construct()
    {
        $this->secretKey = (string)(Setting::get('xendit_secret_key') ?? config('services.xendit.secret_key') ?? '');
        $this->webhookToken = (string)(Setting::get('xendit_webhook_token') ?? config('services.xendit.webhook_token') ?? '');
        $this->isProduction = (Setting::get('xendit_is_production') ?? config('services.xendit.is_production') ?? '0') === '1';
        $this->invoiceDuration = (int)(Setting::get('xendit_invoice_duration') ?? 24);
    }

    /**
     * Check if Xendit payment is enabled and configured.
     */
    public function isEnabled(): bool
    {
        $enabled = Setting::get('xendit_enabled', '0');
        return $enabled === '1' && !empty($this->secretKey);
    }

    /**
     * Create a Xendit Invoice for an order.
     */
    public function createInvoice(Order $order): array
    {
        if (!$this->isEnabled()) {
            return [
                'ok' => false,
                'error' => 'Xendit belum aktif atau belum dikonfigurasi.',
            ];
        }

        $order->loadMissing('kost');

        $successUrl = route('checkout.success', ['invoiceNo' => $order->invoice_no]);

        $payload = [
            'external_id' => $order->invoice_no,
            'amount' => (int)$order->amount,
            'payer_email' => $order->customer_email,
            'description' => 'Unlock Info Kost: ' . ($order->kost->name ?? 'Kost'),
            'invoice_duration' => $this->invoiceDuration * 3600, // convert hours to seconds
            'success_redirect_url' => $successUrl,
            'failure_redirect_url' => $successUrl,
            'currency' => 'IDR',
            'customer' => [
                'given_names' => $order->customer_name,
                'email' => $order->customer_email,
                'mobile_number' => $this->formatPhone($order->customer_whatsapp),
            ],
        ];

        // Map payment method preference
        $paymentMethods = $this->mapPaymentMethods($order->payment_method);
        if (!empty($paymentMethods)) {
            $payload['payment_methods'] = $paymentMethods;
        }

        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post('https://api.xendit.co/v2/invoices', $payload);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'ok' => true,
                    'invoice_id' => $data['id'] ?? null,
                    'invoice_url' => $data['invoice_url'] ?? null,
                ];
            }

            Log::error('Xendit create invoice failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'ok' => false,
                'error' => 'Xendit API error: ' . ($response->json('message') ?? $response->body()),
            ];
        }
        catch (\Exception $e) {
            Log::error('Xendit create invoice exception: ' . $e->getMessage());
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify the Xendit webhook callback token.
     */
    public function verifyWebhookToken(Request $request): bool
    {
        $callbackToken = $request->header('x-callback-token');
        return !empty($this->webhookToken) && $callbackToken === $this->webhookToken;
    }

    /**
     * Test API connection by fetching balance.
     */
    public function testConnection(): array
    {
        if (empty($this->secretKey)) {
            return ['ok' => false, 'error' => 'Secret Key belum diisi.'];
        }

        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->get('https://api.xendit.co/balance');

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'ok' => true,
                    'balance' => $data['balance'] ?? 0,
                ];
            }

            return [
                'ok' => false,
                'error' => 'API Error: ' . ($response->json('message') ?? $response->body()),
            ];
        }
        catch (\Exception $e) {
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Map internal payment method to Xendit payment methods.
     */
    protected function mapPaymentMethods(string $method): array
    {
        return match ($method) {
                'qris' => ['QR_CODE'],
                'gopay' => ['EWALLET'],
                'va' => ['VIRTUAL_ACCOUNT'],
                default => [], // All methods
            };
    }

    /**
     * Format phone number to international format.
     */
    protected function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '+62' . substr($phone, 1);
        }
        elseif (str_starts_with($phone, '62')) {
            $phone = '+' . $phone;
        }
        elseif (!str_starts_with($phone, '+')) {
            $phone = '+62' . $phone;
        }

        return $phone;
    }
}
