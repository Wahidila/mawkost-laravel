<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Services\KostAlertService;
use Illuminate\Console\Command;

class SendKostAlerts extends Command
{
    protected $signature = 'kost:send-alerts';
    protected $description = 'Send notifications to users for new kosts matching their alert criteria';

    public function handle(KostAlertService $service): int
    {
        if (!KostAlertService::isEnabled()) {
            $this->logRun('disabled', 'Fitur alert nonaktif.');
            $this->info('Kost alerts feature is disabled.');
            return 0;
        }

        $this->info('Processing new kost alerts...');

        $result = $service->processNewKosts();

        $summary = "Kost: {$result['kosts_processed']}, Terkirim: {$result['notified']}, Gagal: {$result['failed']}";
        $status = $result['failed'] > 0 ? 'partial' : ($result['notified'] > 0 ? 'success' : 'empty');

        $this->logRun($status, $summary);
        $this->info("Done. {$summary}");

        return 0;
    }

    private function logRun(string $status, string $summary): void
    {
        Setting::set('kost_alerts_last_run', json_encode([
            'at' => now()->toIso8601String(),
            'status' => $status,
            'summary' => $summary,
        ]));
    }
}
