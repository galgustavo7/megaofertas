<?php

namespace App\Support;

use App\Models\Setting;

class Price
{
    /**
     * Formatea un precio con la moneda configurada (ej: $1,299.99).
     */
    public static function format(float|int|string|null $value): string
    {
        $currency = Setting::get('currency', '$');

        return $currency.number_format((float) $value, 2);
    }
}
