<?php

namespace App\Console\Commands;

use App\Services\KostAlertService;
use Illuminate\Console\Command;

class SendKostAlerts extends Command
{
    protected $signature = 'kost:send-alerts';
    protected $description = 'Send notifications to users for new kosts matching their alert criteria';

    public function handle(KostAlertService $service): int
    {
        if (!KostAlertService::isEnabled()) {
            $this->info('Kost alerts feature is disabled.');
            return 0;
        }

        $this->info('Processing new kost alerts...');

        $result = $service->processNewKosts();

        $this->info("Done. Kosts processed: {$result['kosts_processed']}, Notifications sent: {$result['notified']}, Failed: {$result['failed']}");

        return 0;
    }
}
