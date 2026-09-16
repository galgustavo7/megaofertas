<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Sincronización de precios con Amazon (PA-API 5.0)
|--------------------------------------------------------------------------
| Cada precio mostrado en el sitio es un "precio de referencia" con su
| fecha de verificación. Cuando se configuran las credenciales oficiales
| en .env, esta tarea actualiza los precios desde el canal autorizado por
| Amazon (nunca con webscraping), cumpliendo las condiciones de afiliados.
*/
Schedule::command('amazon:sync')->dailyAt('06:00');
