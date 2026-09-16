<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\AmazonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'store_name' => Setting::get('store_name', 'MegaOfertas'),
            'affiliate_tag' => Setting::get('affiliate_tag', ''),
            'amazon_host' => Setting::get('amazon_host', 'www.amazon.com'),
            'currency' => Setting::get('currency', '$'),
            'price_disclaimer' => Setting::get('price_disclaimer', ''),
            'footer_disclosure' => Setting::get('footer_disclosure', ''),
        ];

        $paConfigured = (bool) (env('AMAZON_ACCESS_KEY_ID') && env('AMAZON_SECRET_ACCESS_KEY'));

        return view('admin.settings.index', compact('settings', 'paConfigured'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'store_name' => ['required', 'string', 'max:80'],
            'affiliate_tag' => ['required', 'string', 'max:60'],
            'amazon_host' => ['required', 'string', 'max:80'],
            'currency' => ['required', 'string', 'max:10'],
            'price_disclaimer' => ['required', 'string', 'max:600'],
            'footer_disclosure' => ['required', 'string', 'max:600'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()
            ->route('admin.ajustes')
            ->with('status', 'Ajustes guardados.');
    }

    public function sync(AmazonService $amazon): RedirectResponse
    {
        $result = $amazon->syncPrices();

        return redirect()
            ->route('admin.ajustes')
            ->with($result['ok'] ? 'status' : 'error', $result['message']);
    }
}
