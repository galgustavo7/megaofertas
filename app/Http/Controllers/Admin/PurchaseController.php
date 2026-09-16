<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PurchaseController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('estado');
        $month = $request->input('mes');
        $q = $request->input('q');

        $purchases = Purchase::with('product')
            ->byStatus($status)
            ->inMonth($month)
            ->when($q, function ($query) use ($q) {
                $query->where(fn ($w) => $w
                    ->where('customer_name', 'like', "%{$q}%")
                    ->orWhere('customer_email', 'like', "%{$q}%"));
            })
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $totals = (clone $purchases)->getCollection()->count() > 0
            ? Purchase::with('product')
                ->byStatus($status)
                ->inMonth($month)
                ->when($q, function ($query) use ($q) {
                    $query->where(fn ($w) => $w
                        ->where('customer_name', 'like', "%{$q}%")
                        ->orWhere('customer_email', 'like', "%{$q}%"));
                })
                ->selectRaw('SUM(amount) AS total_amount, SUM(commission) AS total_commission, COUNT(*) AS total_rows')
                ->first()
            : null;

        return view('admin.purchases.index', [
            'purchases' => $purchases,
            'totals' => $totals,
            'status' => $status,
            'month' => $month,
            'q' => $q,
        ]);
    }

    public function updateStatus(Request $request, string $id)
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(Purchase::STATUSES))],
        ]);

        Purchase::findOrFail($id)->update(['status' => $data['status']]);

        return back()->with('status', 'Estado del pedido actualizado.');
    }

    public function export(Request $request): StreamedResponse
    {
        $status = $request->input('estado');
        $month = $request->input('mes');
        $q = $request->input('q');

        $purchases = Purchase::with('product')
            ->byStatus($status)
            ->inMonth($month)
            ->when($q, function ($query) use ($q) {
                $query->where(fn ($w) => $w
                    ->where('customer_name', 'like', "%{$q}%")
                    ->orWhere('customer_email', 'like', "%{$q}%"));
            })
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->get();

        return response()->streamDownload(function () use ($purchases) {
            $out = fopen('php://output', 'w');
            // BOM para que Excel interprete UTF-8
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($out, ['Fecha', 'Producto', 'Cliente', 'Email', 'Importe', 'Comisión', 'Estado']);

            foreach ($purchases as $p) {
                fputcsv($out, [
                    $p->purchase_date->format('d/m/Y'),
                    $p->product?->name ?? '—',
                    $p->customer_name,
                    $p->customer_email,
                    number_format((float) $p->amount, 2, '.', ','),
                    number_format((float) $p->commission, 2, '.', ','),
                    $p->statusLabel(),
                ]);
            }

            fclose($out);
        }, 'compras-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
