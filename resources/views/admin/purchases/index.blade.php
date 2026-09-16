@extends('admin.layouts.app')

@section('title', 'Compras')
@section('topbar', 'Compras y comisiones')

@section('content')
<div class="card">
    <div class="card-head">
        <form class="filter-inline" method="get" action="{{ route('admin.compras') }}">
            <input type="search" name="q" placeholder="Cliente o email…" value="{{ $q }}">
            <select name="estado">
                <option value="">Todos los estados</option>
                @foreach (\App\Models\Purchase::STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <input type="month" name="mes" value="{{ $month }}">
            <button type="submit" class="btn btn-ghost">Filtrar</button>
        </form>
        <a class="btn btn-primary" href="{{ route('admin.compras.export', request()->only(['estado', 'mes', 'q'])) }}">⬇️ Exportar CSV</a>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th><th>Cliente</th><th>Producto</th>
                    <th>Importe</th><th>Comisión</th><th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $p)
                    <tr>
                        <td class="td-muted">{{ $p->purchase_date->format('d M Y') }}</td>
                        <td>
                            <strong>{{ $p->customer_name }}</strong>
                            <small class="td-muted block">{{ $p->customer_email }}</small>
                        </td>
                        <td>
                            @if ($p->product)
                                <a href="{{ route('product', $p->product->slug) }}" target="_blank">{{ $p->product->name }}</a>
                            @else — @endif
                        </td>
                        <td class="td-strong">${{ number_format((float) $p->amount, 2) }}</td>
                        <td class="td-green">${{ number_format((float) $p->commission, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.compras.status', $p->id) }}" class="status-form">
                                @csrf @method('PATCH')
                                <select name="status" class="status-select" onchange="this.form.submit()">
                                    @foreach (\App\Models\Purchase::STATUSES as $key => $label)
                                        <option value="{{ $key }}" @selected($p->status === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="td-empty">No hay compras con esos filtros.</td></tr>
                @endforelse
            </tbody>
            @if ($totals && $totals->total_rows > 0)
                <tfoot>
                    <tr>
                        <td colspan="3" class="td-muted"><strong>Total ({{ $totals->total_rows }} pedidos)</strong></td>
                        <td class="td-strong"><strong>${{ number_format((float) $totals->total_amount, 2) }}</strong></td>
                        <td class="td-green"><strong>${{ number_format((float) $totals->total_commission, 2) }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    <div class="pagination-wrap">{{ $purchases->links('pagination.default') }}</div>
</div>
@endsection
