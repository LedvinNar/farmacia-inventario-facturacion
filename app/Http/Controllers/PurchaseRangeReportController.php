<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchasesReportExport;

class PurchaseRangeReportController extends Controller
{
    /**
     * Reporte parametrizado: Compras por rango de fechas
     * URL: /reports/purchases?from=YYYY-MM-DD&to=YYYY-MM-DD
     */
    public function index(Request $request)
    {
        // 1) Parámetros (por defecto: hoy)
        $from = $request->query('from', now()->toDateString());
        $to   = $request->query('to', now()->toDateString());

        // 2) Normalizar rango
        $fromDT = Carbon::parse($from)->startOfDay();
        $toDT   = Carbon::parse($to)->endOfDay();

        // 3) Compras en el rango
        $purchases = DB::table('purchases as p')
            ->leftJoin('suppliers as s', 's.id', '=', 'p.supplier_id')
            ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
            ->select([
                'p.id',
                'p.purchase_number',
                'p.purchased_at',
                'p.subtotal',
                'p.tax',
                'p.discount',
                'p.total',
                'p.status',
                's.name as supplier_name',
                'u.name as buyer_name',
            ])
            ->whereBetween('p.purchased_at', [$fromDT, $toDT])
            ->orderByDesc('p.purchased_at')
            ->get();

        // 4) Totales
        $totals = [
            'subtotal'  => (float) $purchases->sum('subtotal'),
            'tax'       => (float) $purchases->sum('tax'),
            'discount'  => (float) $purchases->sum('discount'),
            'total'     => (float) $purchases->sum('total'),
            'count'     => (int) $purchases->count(),
        ];

        // 5) Datos farmacia
        $pharmacy = [
            'name'    => 'Silva',
            'phone'   => '+50583818798',
            'address' => 'De la escuela Germán Pomares Ordóñez 10 vrs al oeste una cuadra al Norte',
        ];

        return view('reports.purchases', [
            'pharmacy'  => $pharmacy,
            'purchases' => $purchases,
            'totals'    => $totals,
            'from'      => $fromDT->toDateString(),
            'to'        => $toDT->toDateString(),
        ]);
    }

    public function export(Request $request)
{
    $from = $request->query('from', now()->toDateString());
    $to   = $request->query('to', now()->toDateString());

    return Excel::download(
        new PurchasesReportExport($from, $to),
        'reporte_compras.xlsx'
    );
}

}
