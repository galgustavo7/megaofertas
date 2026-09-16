@extends('admin.layouts.app')

@section('title', 'Ajustes')
@section('topbar', 'Ajustes')

@section('content')
<div class="settings-layout">
    <div class="card">
        <div class="card-head">
            <div>
                <h2>General de la tienda</h2>
                <p>Nombre, tag de afiliado y textos legales de Amazon Associates</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.ajustes.update') }}" class="admin-form">
            @csrf
            <div class="form-row-2">
                <div class="field">
                    <label>Nombre de la tienda</label>
                    <input name="store_name" type="text" required value="{{ old('store_name', $settings['store_name']) }}">
                </div>
                <div class="field">
                    <label>Símbolo de moneda</label>
                    <input name="currency" type="text" required maxlength="10" value="{{ old('currency', $settings['currency']) }}">
                </div>
            </div>
            <div class="form-row-2">
                <div class="field">
                    <label>Tag de afiliado *</label>
                    <input name="affiliate_tag" type="text" required value="{{ old('affiliate_tag', $settings['affiliate_tag']) }}" placeholder="mi-tag-21">
                    <small class="field-hint">Se añade automáticamente a todos los enlaces “Ir a Amazon”</small>
                    @error('affiliate_tag')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label>Host de Amazon</label>
                    <input name="amazon_host" type="text" required value="{{ old('amazon_host', $settings['amazon_host']) }}" placeholder="www.amazon.com">
                </div>
            </div>
            <div class="field">
                <label>Aviso de precio (obligatorio por Amazon) *</label>
                <textarea name="price_disclaimer" rows="2" required>{{ old('price_disclaimer', $settings['price_disclaimer']) }}</textarea>
                @error('price_disclaimer')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field">
                <label>Disclosura de afiliado (pie de página) *</label>
                <textarea name="footer_disclosure" rows="2" required>{{ old('footer_disclosure', $settings['footer_disclosure']) }}</textarea>
                @error('footer_disclosure')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Guardar ajustes</button>
            </div>
        </form>
    </div>

    <div class="card compliance-card">
        <div class="card-head">
            <div>
                <h2>🛡️ Precios y cumplimiento Amazon</h2>
                <p>Estado de la sincronización oficial de precios</p>
            </div>
        </div>
        <ul class="compliance-list">
            <li><strong>Última sincronización:</strong> {{ \App\Models\Setting::get('amazon_last_sync', 'nunca (precios de referencia manuales)') }}</li>
            <li><strong>API PA-API 5.0:</strong>
                @if ($paConfigured)
                    <span class="pill pill-green">Credenciales configuradas ✓</span>
                @else
                    <span class="pill pill-amber">No configurada — modo precio de referencia</span>
                @endif
            </li>
            <li><strong>Programación:</strong> <code>php artisan amazon:sync</code> diaria a las 06:00 (scheduler activo)</li>
        </ul>
        <div class="compliance-note">
            <p>
                <strong>Reglas que aplica la tienda:</strong>
            </p>
            <ol>
                <li>Los precios mostrados son <strong>precios de referencia</strong> con su fecha de verificación; jamás se presentan como precio en vivo sin haber sido actualizados por la API oficial.</li>
                <li>Amazon solo permite actualizar precios automáticamente a través del <strong>Product Advertising API</strong> (PA-API 5.0) con acceso autorizado. Esta app lo implementa con firma AWS SigV4; el comando <code>php artisan amazon:sync</code> lo ejecuta.</li>
                <li>Todo precio visible incluye el aviso legal obligatorio de que <strong>el precio final es el que muestre Amazon en el momento de la compra</strong>.</li>
                <li>Todos los enlaces de compra llevan la <strong>tag de afiliado</strong> y los atributos <code>rel="nofollow sponsored noopener"</code>.</li>
                <li>El pie de página incluye la <strong>disclosura de Amazon Associates</strong> requerida por las condiciones.</li>
            </ol>
            <p>
                Para activar la sincronización automática real, completa en <code>.env</code>:
                <code>AMAZON_ACCESS_KEY_ID</code>, <code>AMAZON_SECRET_ACCESS_KEY</code>,
                <code>AMAZON_ASSOCIATE_TAG</code>, <code>AMAZON_PA_HOST</code>,
                <code>AMAZON_PA_REGION</code> y <code>AMAZON_PA_MARKETPLACE</code>.
            </p>
        </div>
        <form method="POST" action="{{ route('admin.ajustes.sync') }}" class="sync-form"
              data-confirm="¿Ejecutar la sincronización de precios con Amazon ahora?">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg btn-block">🔄 Sincronizar precios ahora</button>
        </form>
    </div>
</div>
@endsection
