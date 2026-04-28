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

        $userKosts = [];

        foreach ($newKosts as $kost) {
            $result['kosts_processed']++;

            foreach ($alerts as $alert) {
                if (!$alert->matchesKost($kost)) {
                    continue;
                }

                $key = $alert->user_id . '_' . $alert->channel;
                if (!isset($userKosts[$key])) {
                    $userKosts[$key] = [
                        'alert' => $alert,
                        'kosts' => collect(),
                    ];
                }
                $userKosts[$key]['kosts']->push($kost);
            }

            $kost->update(['notified_at' => now()]);
        }

        foreach ($userKosts as $entry) {
            $sent = $this->sendBatchNotification($entry['alert'], $entry['kosts']);
            if ($sent) {
                $result['notified']++;
                $entry['alert']->update(['last_notified_at' => now()]);
            } else {
                $result['failed']++;
            }
        }

        return $result;
    }

    public function sendBatchNotification(KostAlert $alert, $kosts): bool
    {
        $user = $alert->user;
        $success = false;

        if (in_array($alert->channel, ['email', 'both'])) {
            try {
                Mail::to($user->email)->send(new KostAlertMail($user, $kosts));
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
                $message = $this->buildWhatsAppDigest($kosts);
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

    protected function buildWhatsAppDigest($kosts): string
    {
        $count = $kosts->count();
        $msg = "🏠 *{$count} Kost Baru di mawkost!*\n";

        foreach ($kosts->take(5) as $i => $kost) {
            $price = 'Rp ' . number_format($kost->price, 0, ',', '.');
            $city = $kost->city->name ?? '-';
            $url = url("/kost/" . ($kost->city->slug ?? '') . "/{$kost->slug}");

            $msg .= "\n*" . ($i + 1) . ". {$kost->title}*\n"
                . "📍 {$city} · 💰 {$price}/bln\n"
                . "👉 {$url}\n";
        }

        if ($count > 5) {
            $more = $count - 5;
            $msg .= "\n_...dan {$more} kost lainnya._\n";
        }

        $msg .= "\n🔍 Lihat semua: " . url('/cari-kost') . "\n"
            . "_Alert mawkost · Kelola di dashboard_";

        return $msg;
    }

    public function sendTestNotification(string $channel, string $target): array
    {
        $testKosts = Kost::with(['city', 'kostType'])->take(3)->get();

        if ($testKosts->isEmpty()) {
            return ['ok' => false, 'message' => 'Tidak ada data kost untuk test.'];
        }

        if ($channel === 'email') {
            try {
                $fakeUser = new \App\Models\User(['name' => 'Test User', 'email' => $target]);
                Mail::to($target)->send(new KostAlertMail($fakeUser, $testKosts));
                return ['ok' => true, 'message' => "Email test berhasil dikirim ke {$target} ({$testKosts->count()} kost)"];
            } catch (\Exception $e) {
                return ['ok' => false, 'message' => 'Gagal kirim email: ' . $e->getMessage()];
            }
        }

        if ($channel === 'whatsapp') {
            $xsender = new XSenderService();
            if (!$xsender->isEnabled()) {
                return ['ok' => false, 'message' => 'WhatsApp API belum aktif.'];
            }
            $message = $this->buildWhatsAppDigest($testKosts);
            $res = $xsender->send($target, $message);
            if ($res['ok']) {
                return ['ok' => true, 'message' => "WhatsApp test berhasil dikirim ke {$target} ({$testKosts->count()} kost)"];
            }
            return ['ok' => false, 'message' => 'Gagal kirim WA: ' . ($res['body'] ?? 'Unknown')];
        }

        return ['ok' => false, 'message' => 'Channel tidak valid.'];
    }
}
