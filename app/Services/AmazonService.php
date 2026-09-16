<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

/**
 * Integración con Amazon Product Advertising API (PA-API 5.0).
 *
 * ─────────────────────────────────────────────────────────────────────────
 *  CUMPLIMIENTO AMAZON ASSOCIATES (precios)
 * ─────────────────────────────────────────────────────────────────────────
 *  Las condiciones de Amazon exigen que los precios mostrados en un sitio
 *  de afiliados procedan del Product Advertising API y que se acompañen de
 *  un aviso de que "el precio y la disponibilidad pueden variar". Este
 *  servicio es la ÚNICA fuente legítima para actualizar precios de forma
 *  automática:
 *
 *   1. Nunca se simulan precios "en vivo" si no provienen de PA-API.
 *   2. Cada precio guardado lleva price_updated_at (última verificación).
 *   3. La UI siempre muestra la etiqueta "Precio de referencia" + la fecha
 *      de verificación y el aviso legal obligatorio.
 *   4. La sincronización se ejecuta vía `php artisan amazon:sync`
 *      (programable por cron), nunca con webscraping de páginas de Amazon.
 *
 *  Para activar la sincronización real, completa en .env:
 *      AMAZON_ACCESS_KEY_ID=...
 *      AMAZON_SECRET_ACCESS_KEY=...
 *      AMAZON_ASSOCIATE_TAG=...      (se guarda además en "Ajustes")
 *      AMAZON_PA_HOST=webservices.amazon.com
 *      AMAZON_PA_REGION=us-east-1
 *      AMAZON_PA_MARKETPLACE=ATVPDKIKX0DER
 * ─────────────────────────────────────────────────────────────────────────
 */
class AmazonService
{
    /**
     * Sincroniza los precios de los productos vía PA-API GetItems.
     *
     * @return array{ok: bool, message: string, updated: int}
     */
    public function syncPrices(): array
    {
        $accessKey = env('AMAZON_ACCESS_KEY_ID');
        $secretKey = env('AMAZON_SECRET_ACCESS_KEY');
        $associate = env('AMAZON_ASSOCIATE_TAG', Setting::get('affiliate_tag'));
        $host = env('AMAZON_PA_HOST', 'webservices.amazon.com');
        $region = env('AMAZON_PA_REGION', 'us-east-1');
        $marketplace = env('AMazon_PA_MARKETPLACE', 'ATVPDKIKX0DER');

        if (! $accessKey || ! $secretKey || ! $associate) {
            return [
                'ok' => false,
                'updated' => 0,
                'message' => 'Credenciales PA-API no configuradas. Los precios se mantienen como "precio de referencia" con su fecha de verificación (modo conforme a las condiciones de Amazon).',
            ];
        }

        $asins = Product::query()->pluck('asin');
        $updated = 0;

        foreach (array_chunk($asins->all(), 10) as $chunk) {
            $payload = [
                'Items' => collect($chunk)->map(fn ($asin) => [
                    'ASIN' => $asin,
                    'ItemInfo' => [
                        'itemInfos' => [
                            'offerings' => ['_groups' => ['pricing']],
                            'product' => ['attributes' => ['title', 'images']],
                        ],
                    ],
                ])->all(),
                'PartnerType' => 'Associates',
                'PartnerTag' => $associate,
                'Marketplace' => $marketplace,
            ];

            $response = $this->paApi('GetItem', $host, $region, $accessKey, $secretKey, $payload);

            if (! is_array($response) || ! isset($response['PricingResponses'])) {
                Log::warning('PA-API respondió inesperadamente', is_array($response) ? $response : []);
                continue;
            }

            foreach ($response['PricingResponses'] as $asinsGroup => $res) {
                foreach (($res['PricingResults'] ?? []) as $result) {
                    $asin = $result['ASIN'] ?? null;
                    if (! $asin) {
                        continue;
                    }

                    $pricePath = $result['ItemInfo']['offerings']['offerings']['Offering'][0]
                        ['pricing']['Pricing'] ?? null;

                    if (! $pricePath) {
                        continue;
                    }

                    $current = $pricePath['Price']['DisplayAmount'] ?? null;
                    $list = $pricePath['ListPrice']['DisplayAmount']
                        ?? $pricePath['TypicalPrice']['DisplayAmount'] ?? null;

                    $num = fn ($v) => $v !== null ? (float) str_replace(['$', ','], '', $v) : null;
                    $price = $num($current);

                    if ($price === null || $price <= 0) {
                        continue;
                    }

                    $product = Product::query()->where('asin', $asin)->first();
                    if (! $product) {
                        continue;
                    }

                    $product->update([
                        'price' => $price,
                        'list_price' => $num($list) ?: $product->list_price,
                        'price_updated_at' => now(),
                    ]);

                    $updated++;
                }
            }
        }

        Setting::set('amazon_last_sync', now()->format('Y-m-d H:i:s'));

        return [
            'ok' => true,
            'updated' => $updated,
            'message' => "Sincronización completada: {$updated} precios actualizados desde PA-API.",
        ];
    }

    /**
     * Llamada firmada (AWS Signature v4) a PA-API 5.0.
     */
    private function paApi(string $action, string $host, string $region, string $accessKey, string $secretKey, array $payload): ?array
    {
        $path = '/paapi5/'.$action;
        $body = json_encode($payload);
        $amzDate = gmdate('Ymd\THis\Z');
        $dateStamp = gmdate('Ymd');
        $service = 'soap'; // PA-API 5.0 firma con el servicio "soap"
        $hashedPayload = hash('sha256', $body);

        $headers = [
            'host' => $host,
            'x-amz-date' => $amzDate,
            'x-amz-target' => 'ProductAdvertisingAPIv1.'.$action,
            'content-type' => 'application/json; charset=utf-8',
        ];

        $canonicalHeaders = '';
        $signedHeaders = [];
        foreach ($headers as $k => $v) {
            $canonicalHeaders .= strtolower($k).':'.trim($v)."\n";
            $signedHeaders[] = strtolower($k);
        }
        $signedHeaders = implode(';', $signedHeaders);

        $canonicalRequest = implode("\n", [
            'POST',
            $path,
            '', // query string vacío
            $canonicalHeaders,
            $signedHeaders,
            $hashedPayload,
        ]);

        $scope = "{$dateStamp}/{$region}/{$service}/aws4_request";
        $stringToSign = implode("\n", [
            'AWS4-HMAC-SHA256',
            $amzDate,
            $scope,
            hash('sha256', $canonicalRequest),
        ]);

        $kSecret = 'AWS4'.$secretKey;
        $kDate = $this->hmac($kSecret, $dateStamp);
        $kRegion = $this->hmac($kDate, $region);
        $kService = $this->hmac($kRegion, $service);
        $signingKey = $this->hmac($kService, 'aws4_request');
        $signature = hash_hmac('sha256', $stringToSign, $signingKey);

        $authorization = sprintf(
            'AWS4-HMAC-SHA256 Credential=%s/%s, SignedHeaders=%s, Signature=%s',
            $accessKey,
            $scope,
            $signedHeaders,
            $signature,
        );

        $ch = curl_init('https://'.$host.$path);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => array_merge($headers, [
                'Authorization' => $authorization,
            ]),
        ]);
        $response = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            Log::warning('PA-API HTTP '.$httpCode, ['body' => mb_substr((string) $response, 0, 500)]);

            return null;
        }

        return json_decode((string) $response, true);
    }

    private function hmac(string $key, string $data): string
    {
        return hash_hmac('sha256', $data, $key, true);
    }
}
