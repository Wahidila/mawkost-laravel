<?php

namespace App\Services;

use App\Mail\KostAlertMail;
use App\Models\Kost;
use App\Models\KostAlert;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KostAlertService
{
    public static function isEnabled(): bool
    {
        return Setting::get('kost_alerts_enabled', '0') === '1';
    }

    public function processNewKosts(): array
    {
        $result = ['notified' => 0, 'failed' => 0, 'kosts_processed' => 0];

        if (!self::isEnabled()) {
            return $result;
        }

        $newKosts = Kost::with(['city', 'kostType'])
            ->whereNull('notified_at')
            ->get();

        if ($newKosts->isEmpty()) {
            return $result;
        }

        $alerts = KostAlert::with('user')
            ->where('is_active', true)
            ->get();

        foreach ($newKosts as $kost) {
            $result['kosts_processed']++;

            foreach ($alerts as $alert) {
                if (!$alert->matchesKost($kost)) {
                    continue;
                }

                $sent = $this->sendNotification($alert, $kost);
                if ($sent) {
                    $result['notified']++;
                    $alert->update(['last_notified_at' => now()]);
                } else {
                    $result['failed']++;
                }
            }

            $kost->update(['notified_at' => now()]);
        }

        return $result;
    }

    public function sendNotification(KostAlert $alert, Kost $kost): bool
    {
        $user = $alert->user;
        $success = false;

        if (in_array($alert->channel, ['email', 'both'])) {
            try {
                Mail::to($user->email)->send(new KostAlertMail($user, $kost));
                $success = true;
            } catch (\Exception $e) {
                Log::error('KostAlert email failed', [
                    'alert_id' => $alert->id,
                    'user_email' => $user->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if (in_array($alert->channel, ['whatsapp', 'both'])) {
            $xsender = new XSenderService();
            if ($xsender->isEnabled() && $user->whatsapp) {
                $message = $this->buildWhatsAppMessage($user, $kost);
                $res = $xsender->send($user->whatsapp, $message);
                if ($res['ok']) {
                    $success = true;
                } else {
                    Log::error('KostAlert WhatsApp failed', [
                        'alert_id' => $alert->id,
                        'phone' => $user->whatsapp,
                        'error' => $res['body'] ?? 'Unknown',
                    ]);
                }
            }
        }

        return $success;
    }

    protected function buildWhatsAppMessage($user, Kost $kost): string
    {
        $price = 'Rp ' . number_format($kost->price, 0, ',', '.');
        $city = $kost->city->name ?? '-';
        $type = $kost->kostType->name ?? ucfirst($kost->type);
        $url = url("/kost/" . ($kost->city->slug ?? '') . "/{$kost->slug}");

        return "🏠 *Kost Baru di mawkost!*\n\n"
            . "*{$kost->title}*\n"
            . "📍 {$city} — {$kost->area_label}\n"
            . "🏷️ Tipe: {$type}\n"
            . "💰 {$price}/bulan\n\n"
            . "👉 Lihat detail: {$url}\n\n"
            . "_Kamu menerima pesan ini karena mengaktifkan alert kost di mawkost._";
    }

    public function sendTestNotification(string $channel, string $target): array
    {
        $testKost = Kost::with(['city', 'kostType'])->first();

        if (!$testKost) {
            return ['ok' => false, 'message' => 'Tidak ada data kost untuk test.'];
        }

        if ($channel === 'email') {
            try {
                $fakeUser = new \App\Models\User(['name' => 'Test User', 'email' => $target]);
                Mail::to($target)->send(new KostAlertMail($fakeUser, $testKost));
                return ['ok' => true, 'message' => "Email test berhasil dikirim ke {$target}"];
            } catch (\Exception $e) {
                return ['ok' => false, 'message' => 'Gagal kirim email: ' . $e->getMessage()];
            }
        }

        if ($channel === 'whatsapp') {
            $xsender = new XSenderService();
            if (!$xsender->isEnabled()) {
                return ['ok' => false, 'message' => 'WhatsApp API belum aktif.'];
            }
            $fakeUser = new \App\Models\User(['name' => 'Test User']);
            $message = $this->buildWhatsAppMessage($fakeUser, $testKost);
            $res = $xsender->send($target, $message);
            if ($res['ok']) {
                return ['ok' => true, 'message' => "WhatsApp test berhasil dikirim ke {$target}"];
            }
            return ['ok' => false, 'message' => 'Gagal kirim WA: ' . ($res['body'] ?? 'Unknown')];
        }

        return ['ok' => false, 'message' => 'Channel tidak valid.'];
    }
}
