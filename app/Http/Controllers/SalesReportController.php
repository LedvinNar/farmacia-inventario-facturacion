<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// ✅ Excel (si ya tenés maatwebsite/excel instalado)
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesReportController extends Controller
{
    /**
     * Reporte parametrizado: Ventas por rango de fechas (con filtros PRO)
     * URL: /reports/sales?from=YYYY-MM-DD&to=YYYY-MM-DD&status=&payment_method=&q=
     */
    public function index(Request $request)
    {
        // ✅ Validación segura (evita errores por fechas raras)
        $data = $request->validate([
            'from' => ['nullable', 'date'],
            'to'   => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'q' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:5', 'max:200'],
        ]);

        // 1) Rango por defecto: hoy
        $from = $data['from'] ?? now()->toDateString();
        $to   = $data['to']   ?? now()->toDateString();

        // 2) Normalizar rango (00:00:00 a 23:59:59) + seguridad si vienen invertidas
        $fromDT = Carbon::parse($from)->startOfDay();
        $toDT   = Carbon::parse($to)->endOfDay();

        if ($fromDT->gt($toDT)) {
            [$fromDT, $toDT] = [$toDT->copy()->startOfDay(), $fromDT->copy()->endOfDay()];
        }

        // 3) Filtros PRO
        $filters = [
            'status' => isset($data['status']) && $data['status'] !== '' ? strtolower(trim($data['status'])) : null,
            'payment_method' => isset($data['payment_method']) && $data['payment_method'] !== '' ? strtolower(trim($data['payment_method'])) : null,
            'q' => isset($data['q']) && $data['q'] !== '' ? trim($data['q']) : null,
        ];

        // 4) Query base reutilizable (PRO)
        $query = $this->buildSalesQuery($fromDT, $toDT, $filters);

        // 5) Paginación (PRO)
        $perPage = (int)($data['per_page'] ?? 25);

        // Importante: paginar primero, pero sin perder filtros en la URL
        $sales = $query
            ->orderByDesc('s.sold_at')
            ->paginate($perPage)
            ->withQueryString();

        // 6) Totales (PRO) — se calculan sin paginación (sobre TODO el rango filtrado)
        $totalsQuery = $this->buildSalesQuery($fromDT, $toDT, $filters);

        $totalsRow = $totalsQuery
    ->select([]) // ✅ resetea columnas anteriores
    ->selectRaw('
        COALESCE(SUM(s.subtotal),0) as subtotal,
        COALESCE(SUM(s.tax),0) as tax,
        COALESCE(SUM(s.discount),0) as discount,
        COALESCE(SUM(s.total),0) as total,
        COUNT(*) as count
    ')
    ->first();

        $totals = [
            'subtotal' => (float)($totalsRow->subtotal ?? 0),
            'tax'      => (float)($totalsRow->tax ?? 0),
            'discount' => (float)($totalsRow->discount ?? 0),
            'total'    => (float)($totalsRow->total ?? 0),
            'count'    => (int)($totalsRow->count ?? 0),
        ];

        // 7) Datos farmacia (mantenidos, como vos ya lo tenías)
        $pharmacy = [
            'name'    => 'Silva',
            'phone'   => '+50583818798',
            'address' => 'De la escuela Germán Pomares Ordóñez 10 vrs al oeste una cuadra al Norte',
        ];

        return view('reports.sales', [
            'pharmacy' => $pharmacy,
            'sales'    => $sales,   // ✅ ahora es paginator (más pro)
            'totals'   => $totals,
            'from'     => $fromDT->toDateString(),
            'to'       => $toDT->toDateString(),

            // ✅ extras para tu vista (filtros)
            'filters'  => $filters,
            'perPage'  => $perPage,
        ]);
    }

    /**
     * ✅ Exportar Excel (mismos filtros que la pantalla)
     * URL: /reports/sales/export?from=...&to=...&status=...&payment_method=...&q=...
     */
    public function export(Request $request)
    {
        // Misma validación que index
        $data = $request->validate([
            'from' => ['nullable', 'date'],
            'to'   => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $from = $data['from'] ?? now()->toDateString();
        $to   = $data['to']   ?? now()->toDateString();

        $fromDT = Carbon::parse($from)->startOfDay();
        $toDT   = Carbon::parse($to)->endOfDay();

        if ($fromDT->gt($toDT)) {
            [$fromDT, $toDT] = [$toDT->copy()->startOfDay(), $fromDT->copy()->endOfDay()];
        }

        $filters = [
            'status' => isset($data['status']) && $data['status'] !== '' ? strtolower(trim($data['status'])) : null,
            'payment_method' => isset($data['payment_method']) && $data['payment_method'] !== '' ? strtolower(trim($data['payment_method'])) : null,
            'q' => isset($data['q']) && $data['q'] !== '' ? trim($data['q']) : null,
        ];

        $rows = $this->buildSalesQuery($fromDT, $toDT, $filters)
            ->orderByDesc('s.sold_at')
            ->get();

        $fileName = 'reporte_ventas_' . $fromDT->format('Ymd') . '_a_' . $toDT->format('Ymd') . '.xlsx';

        // ✅ Export “inline” (sin crear archivos extra)
        $export = new class($rows) implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize {
            public function __construct(private $rows) {}

            public function collection()
            {
                return $this->rows;
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Factura',
                    'Fecha/Hora',
                    'Cliente',
                    'Vendedor',
                    'Método Pago',
                    'Estado',
                    'Subtotal',
                    'Impuesto',
                    'Descuento',
                    'Total',
                ];
            }

            public function map($r): array
            {
                return [
                    $r->id,
                    $r->invoice_number ?? ('VTA-' . $r->id),
                    $r->sold_at ? Carbon::parse($r->sold_at)->format('d/m/Y H:i') : 'N/D',
                    $r->customer_name ?? 'Consumidor final',
                    $r->seller_name ?? 'N/D',
                    $r->payment_method ?? 'N/D',
                    $r->status ?? 'N/D',
                    (float)($r->subtotal ?? 0),
                    (float)($r->tax ?? 0),
                    (float)($r->discount ?? 0),
                    (float)($r->total ?? 0),
                ];
            }
        };

        return Excel::download($export, $fileName);
    }

    /**
     * 🔒 Query base PRO: misma consulta para pantalla y export.
     */
    private function buildSalesQuery(Carbon $fromDT, Carbon $toDT, array $filters)
    {
        $q = DB::table('sales as s')
            ->leftJoin('customers as c', 'c.id', '=', 's.customer_id')
            ->leftJoin('users as u', 'u.id', '=', 's.user_id')
            ->select([
                's.id',
                's.invoice_number',
                's.sold_at',
                's.subtotal',
                's.tax',
                's.discount',
                's.total',
                's.status',
                's.payment_method',

                // Cliente
                'c.name as customer_name',
                'c.phone as customer_phone',
                'c.email as customer_email',

                // Vendedor
                'u.name as seller_name',
            ])
            ->whereBetween('s.sold_at', [$fromDT, $toDT]);

        // ✅ Filtro por estado
        if (!empty($filters['status'])) {
            $q->whereRaw('LOWER(COALESCE(s.status, "")) = ?', [$filters['status']]);
        }

        // ✅ Filtro por método de pago
        if (!empty($filters['payment_method'])) {
            $q->whereRaw('LOWER(COALESCE(s.payment_method, "")) = ?', [$filters['payment_method']]);
        }

        // ✅ Búsqueda PRO (factura / cliente / vendedor)
        if (!empty($filters['q'])) {
            $needle = '%' . strtolower($filters['q']) . '%';
            $q->where(function ($w) use ($needle) {
                $w->whereRaw('LOWER(COALESCE(s.invoice_number,"")) LIKE ?', [$needle])
                  ->orWhereRaw('LOWER(COALESCE(c.name,"")) LIKE ?', [$needle])
                  ->orWhereRaw('LOWER(COALESCE(u.name,"")) LIKE ?', [$needle]);
            });
        }

        return $q;
    }
}
