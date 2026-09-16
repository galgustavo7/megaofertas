<?php

namespace App\Console\Commands;

use App\Services\AmazonService;
use Illuminate\Console\Command;

class AmazonSyncPrices extends Command
{
    protected $signature = 'amazon:sync';

    protected $description = 'Sincroniza precios de referencia con Amazon PA-API 5.0 (canal oficial y conforme a las condiciones de afiliados)';

    public function handle(AmazonService $amazon): int
    {
        $this->info('Sincronizando precios con Amazon (PA-API 5.0)...');

        $result = $amazon->syncPrices();

        $this->{$result['ok'] ? 'info' : 'warn'}($result['message']);

        return self::SUCCESS;
    }
}
