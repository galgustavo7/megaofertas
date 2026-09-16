<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = Carbon::now();

        // ── KPIs del mes actual vs mes anterior ─────────────────────────
        $kpi = fn (Carbon $from, Carbon $to) => [
            'revenue' => (float) Purchase::where('status', '!=', 'reversado')
                ->whereBetween('purchase_date', [$from, $to])
                ->sum('amount'),
            'orders' => (int) Purchase::whereBetween('purchase_date', [$from, $to])->count(),
            'commission' => (float) Purchase::where('status', '!=', 'reversado')
                ->whereBetween('purchase_date', [$from, $to])
                ->sum('commission'),
        ];

        $current = $kpi($now->copy()->startOfMonth(), $now);
        $previous = $kpi(
            $now->copy()->subMonthNoOverflow()->startOfMonth(),
            $now->copy()->subMonthNoOverflow()->endOfMonth(),
        );

        $delta = fn (float $c, float $p) => $p > 0 ? round(($c - $p) / $p * 100) : ($c > 0 ? 100 : 0);

        $kpis = [
            [
                'label' => 'Ingresos del mes',
                'value' => '$'.number_format($current['revenue'], 0),
                'delta' => $delta($current['revenue'], $previous['revenue']),
                'icon' => '💰',
                'color' => '#4F46E5',
            ],
            [
                'label' => 'Pedidos del mes',
                'value' => (string) $current['orders'],
                'delta' => $delta($current['orders'], $previous['orders']),
                'icon' => '🛒',
                'color' => '#0EA5E9',
            ],
            [
                'label' => 'Comisión del mes',
                'value' => '$'.number_format($current['commission'], 0),
                'delta' => $delta($current['commission'], $previous['commission']),
                'icon' => '📈',
                'color' => '#10B981',
            ],
            [
                'label' => 'Comisión media / pedido',
                'value' => '$'.number_format($current['orders'] > 0 ? $current['commission'] / $current['orders'] : 0, 2),
                'delta' => $delta(
                    $current['orders'] > 0 ? $current['commission'] / $current['orders'] : 0,
                    $previous['orders'] > 0 ? $previous['commission'] / $previous['orders'] : 0,
                ),
                'icon' => '🎯',
                'color' => '#F59E0B',
            ],
        ];

        // ── Gráfica: últimos 12 meses (ingresos y comisión por mes) ────
        $start = $now->copy()->subMonthsNoOverflow(11)->startOfMonth();
        $data = Purchase::query()
            ->selectRaw("strftime('%Y-%m', purchase_date) AS ym,
                         SUM(CASE WHEN status != 'reversado' THEN amount ELSE 0 END) AS revenue,
                         SUM(CASE WHEN status != 'reversado' THEN commission ELSE 0 END) AS commission")
            ->where('purchase_date', '>=', $start)
            ->groupBy('ym')
            ->get()
            ->keyBy('ym');

        $labels = [];
        $revenue = [];
        $commission = [];
        $short = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonthsNoOverflow($i);
            $key = $month->format('Y-m');
            $labels[] = $short[$month->month - 1].' '.substr($month->format('Y'), 2);
            $revenue[] = round((float) ($data[$key]['revenue'] ?? 0), 2);
            $commission[] = round((float) ($data[$key]['commission'] ?? 0), 2);
        }

        // ── Distribución por estado ────────────────────────────────────
        $statusCounts = Purchase::query()
            ->selectRaw('status, COUNT(*) AS total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // ── Top 5 productos por ingresos ───────────────────────────────
        $topProducts = Purchase::query()
            ->where('status', '!=', 'reversado')
            ->join('products', 'products.id', '=', 'purchases.product_id')
            ->selectRaw('products.name, products.emoji, products.slug, COUNT(*) AS orders, SUM(purchases.amount) AS revenue')
            ->groupBy('products.id', 'products.name', 'products.emoji', 'products.slug')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // ── Últimos pedidos ────────────────────────────────────────────
        $recent = Purchase::with('product')
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        $totalPurchases = Purchase::count();

        $chartData = [
            'labels' => $labels,
            'revenue' => $revenue,
            'commission' => $commission,
            'status' => $statusCounts,
        ];

        return view('admin.dashboard', compact(
            'kpis', 'chartData', 'topProducts', 'recent', 'totalPurchases'
        ));
    }
}
