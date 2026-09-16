<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'store_name' => 'MegaOfertas',
            'affiliate_tag' => 'megaofertas-21',
            'amazon_host' => 'www.amazon.com',
            'currency' => '$',
            'price_disclaimer' => 'Los precios y la disponibilidad de los productos mostrados en este sitio son de referencia y pueden variar. El precio final es el que muestre Amazon en el momento de la compra.',
            'footer_disclosure' => 'Como Asociado de Amazon, MegaOfertas obtiene ingresos por las compras adscritas que cumplen los requisitos aplicables.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
