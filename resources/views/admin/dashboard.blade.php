@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('topbar', 'Dashboard')

@section('content')

<!-- KPIs -->
<div class="kpi-grid">
    @foreach ($kpis as $kpi)
        <div class="kpi-card" style="--kpi-color: {{ $kpi['color'] }}">
            <div class="kpi-top">
                <span class="kpi-icon">{{ $kpi['icon'] }}</span>
                <span class="kpi-delta {{ $kpi['delta'] >= 0 ? 'up' : 'down' }}">
                    {{ $kpi['delta'] >= 0 ? '▲' : '▼' }} {{ abs($kpi['delta']) }}% vs mes ant.
                </span>
            </div>
            <strong class="kpi-value">{{ $kpi['value'] }}</strong>
            <span class="kpi-label">{{ $kpi['label'] }}</span>
        </div>
    @endforeach
</div>

<!-- Gráfica principal -->
<div class="card chart-card">
    <div class="card-head">
        <div>
            <h2>Estadísticas de ventas · últimos 12 meses</h2>
            <p>Ingresos totales (sin reversados) y comisión de afiliado generada por mes</p>
        </div>
        <span class="chart-pill">📈 {{ $totalPurchases }} pedidos registrados</span>
    </div>
    <div class="chart-box">
        <canvas id="revenueChart" height="120"></canvas>
    </div>
</div>

<div class="dash-row">
    <!-- Doughnut estados -->
    <div class="card">
        <div class="card-head"><div><h2>Estados de las compras</h2><p>Distribución total de pedidos</p></div></div>
        <div class="chart-box chart-box-sm doughnut-wrap">
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    <!-- Top productos -->
    <div class="card">
        <div class="card-head"><div><h2>Top 5 productos</h2><p>Por ingresos generados</p></div></div>
        <ul class="top-products">
            @forelse ($topProducts as $i => $tp)
                <li class="tp-row">
                    <span class="tp-rank">{{ $i + 1 }}</span>
                    <span class="tp-emoji">{{ $tp->emoji }}</span>
                    <div class="tp-info">
                        <a href="{{ route('product', $tp->slug) }}" target="_blank">{{ $tp->name }}</a>
                        <small>{{ $tp->orders }} pedidos</small>
                    </div>
                    <strong class="tp-revenue">${{ number_format((float) $tp->revenue, 0) }}</strong>
                </li>
            @empty
                <li class="tp-empty">Sin datos aún</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Últimos pedidos -->
<div class="card">
    <div class="card-head">
        <div><h2>Últimos pedidos</h2><p>Comprador, producto y estado de la comisión</p></div>
        <a class="btn btn-ghost" href="{{ route('admin.compras') }}">Ver todos →</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr><th>Fecha</th><th>Cliente</th><th>Producto</th><th>Importe</th><th>Comisión</th><th>Estado</th></tr>
            </thead>
            <tbody>
                @foreach ($recent as $p)
                    <tr>
                        <td class="td-muted">{{ $p->purchase_date->format('d M Y') }}</td>
                        <td>{{ $p->customer_name }}</td>
                        <td>{{ $p->product?->name ?? '—' }}</td>
                        <td class="td-strong">${{ number_format((float) $p->amount, 2) }}</td>
                        <td class="td-green">${{ number_format((float) $p->commission, 2) }}</td>
                        <td><span class="status-badge status-{{ $p->status }}">{{ $p->statusLabel() }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script id="chart-data" type="application/json">@json($chartData)</script>

@endsection
