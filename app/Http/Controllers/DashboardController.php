<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Datos farmacia (podés moverlos luego a .env / config)
        $pharmacy = [
            'name'    => 'Silva',
            'phone'   => '+50583818798',
            'address' => 'De la escuela Germán Pomares Ordóñez 10 vrs al oeste una cuadra al Norte',
        ];

        // Rangos
        $todayStart = now()->startOfDay();
        $todayEnd   = now()->endOfDay();
        $monthStart = now()->startOfMonth();
        $monthEnd   = now()->endOfMonth();

        $from12m = now()->subMonths(11)->startOfMonth();
        $to12m   = now()->endOfMonth();

        // ====== KPIs ======
        $salesToday = DB::table('sales')->whereBetween('sold_at', [$todayStart, $todayEnd]);
        $salesMonth = DB::table('sales')->whereBetween('sold_at', [$monthStart, $monthEnd]);
        $sales12m   = DB::table('sales')->whereBetween('sold_at', [$from12m, $to12m]);

        $purchasesToday = DB::table('purchases')->whereBetween('purchased_at', [$todayStart, $todayEnd]);
        $purchasesMonth = DB::table('purchases')->whereBetween('purchased_at', [$monthStart, $monthEnd]);
        $purchases12m   = DB::table('purchases')->whereBetween('purchased_at', [$from12m, $to12m]);

        $kpis = [
            'sales_today' => (float) $salesToday->sum('total'),
            'sales_today_count' => (int) $salesToday->count(),

            'purchases_today' => (float) $purchasesToday->sum('total'),
            'purchases_today_count' => (int) $purchasesToday->count(),

            'sales_month' => (float) $salesMonth->sum('total'),
            'sales_month_count' => (int) $salesMonth->count(),

            'purchases_month' => (float) $purchasesMonth->sum('total'),
            'purchases_month_count' => (int) $purchasesMonth->count(),

            'sales_total_12m' => (float) $sales12m->sum('total'),
            'purchases_total_12m' => (float) $purchases12m->sum('total'),
        ];

        // Utilidad aprox (sin costos detallados): ventas - compras
        $kpis['gross_12m'] = (float) ($kpis['sales_total_12m'] - $kpis['purchases_total_12m']);

        // ====== Gráfico 1: Ventas por mes (12 meses) ======
        $salesByMonth = DB::table('sales')
            ->selectRaw("DATE_FORMAT(sold_at, '%Y-%m') as ym, SUM(total) as total")
            ->whereBetween('sold_at', [$from12m, $to12m])
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        // ====== Gráfico 2: Compras por mes (12 meses) ======
        $purchasesByMonth = DB::table('purchases')
            ->selectRaw("DATE_FORMAT(purchased_at, '%Y-%m') as ym, SUM(total) as total")
            ->whereBetween('purchased_at', [$from12m, $to12m])
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        // Construir labels/values completos (incluye meses sin datos)
        $months = [];
        $cursor = $from12m->copy();
        while ($cursor <= $to12m) {
            $months[] = $cursor->format('Y-m');
            $cursor->addMonth();
        }

        $salesLabels = $months;
        $salesValues = array_map(fn($m) => (float)(($salesByMonth[$m]->total ?? 0)), $months);

        $purchasesLabels = $months;
        $purchasesValues = array_map(fn($m) => (float)(($purchasesByMonth[$m]->total ?? 0)), $months);

        // ====== Gráfico 3: Top productos vendidos (INTENTA sale_items) ======
        $topLabels = [];
        $topValues = [];

        if (Schema::hasTable('sale_items') && Schema::hasTable('products')) {
            $nameCol = Schema::hasColumn('products', 'name') ? 'name' : (Schema::hasColumn('products', 'product_name') ? 'product_name' : null);

            if ($nameCol) {
                $top = DB::table('sale_items as si')
                    ->join('products as p', 'p.id', '=', 'si.product_id')
                    ->selectRaw("p.$nameCol as name, SUM(si.quantity) as qty")
                    ->groupBy("p.$nameCol")
                    ->orderByDesc('qty')
                    ->limit(10)
                    ->get();

                $topLabels = $top->pluck('name')->toArray();
                $topValues = $top->pluck('qty')->map(fn($x) => (float)$x)->toArray();
            }
        }

        // ====== Gráfico 4: Stock bajo (tabla) ======
        $stockThreshold = 10;
        $lowStock = [];

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'stock')) {
            $nameCol = Schema::hasColumn('products', 'name') ? 'name' : (Schema::hasColumn('products', 'product_name') ? 'product_name' : null);

            if ($nameCol) {
                $lowStock = DB::table('products')
                    ->select([$nameCol . ' as name', 'stock'])
                    ->where('stock', '<=', $stockThreshold)
                    ->orderBy('stock')
                    ->limit(10)
                    ->get();
            }
        }

        // ====== Gráfico 5: Ventas por método de pago (Pie) ======
        $paymentLabels = [];
        $paymentValues = [];

        if (Schema::hasTable('sales') && Schema::hasColumn('sales', 'payment_method')) {
            $paymentData = DB::table('sales')
                ->selectRaw("payment_method, SUM(total) as total")
                ->whereBetween('sold_at', [$from12m, $to12m])
                ->groupBy('payment_method')
                ->orderByDesc('total')
                ->get();

            $paymentLabels = $paymentData->pluck('payment_method')->toArray();
            $paymentValues = $paymentData->pluck('total')->map(fn($x) => (float)$x)->toArray();
        }

        // ====== Gráfico 6: Ventas por vendedor (PRO: por NOMBRE de usuario) ======
        $salesBySellerLabels = [];
        $salesBySellerValues = [];

        if (Schema::hasTable('sales') && Schema::hasTable('users')) {

            // Detectar columna FK en sales hacia users
            $salesUserCol = null;
            foreach (['user_id', 'seller_id', 'cashier_id'] as $c) {
                if (Schema::hasColumn('sales', $c)) { $salesUserCol = $c; break; }
            }

            // Detectar columna de nombre en users
            $userNameCol = null;
            foreach (['name', 'full_name', 'nombre'] as $c) {
                if (Schema::hasColumn('users', $c)) { $userNameCol = $c; break; }
            }

            if ($salesUserCol && $userNameCol) {

                $q = DB::table('sales as s')
                    ->join('users as u', 'u.id', '=', "s.$salesUserCol")
                    ->selectRaw("u.$userNameCol as seller, SUM(s.total) as total")
                    ->whereBetween('s.sold_at', [$from12m, $to12m])
                    ->groupBy("u.$userNameCol")
                    ->orderByDesc('total')
                    ->limit(10);

                // (Opcional PRO): si tu users tiene columna de rol, filtrá solo vendedores
                // Ajustá el valor según tu BD: 'Vendedor', 'vendedor', 'seller', etc.
                $roleCol = null;
                foreach (['role', 'rol', 'user_type', 'type'] as $c) {
                    if (Schema::hasColumn('users', $c)) { $roleCol = $c; break; }
                }
                if ($roleCol) {
                    $q->whereIn("u.$roleCol", ['Vendedor', 'vendedor', 'SELLER', 'seller']);
                }

                $seller = $q->get();

                $salesBySellerLabels = $seller->pluck('seller')->toArray();
                $salesBySellerValues = $seller->pluck('total')->map(fn($x) => (float)$x)->toArray();
            }
        }

        $charts = [
            'sales_months'      => ['labels' => $salesLabels,      'values' => $salesValues],
            'purchases_months'  => ['labels' => $purchasesLabels,  'values' => $purchasesValues],
            'top_products'      => ['labels' => $topLabels,        'values' => $topValues],
            'payment_methods'   => ['labels' => $paymentLabels,    'values' => $paymentValues],
            'sales_by_seller'   => ['labels' => $salesBySellerLabels, 'values' => $salesBySellerValues],
        ];

        return view('dashboard', [
            'pharmacy' => $pharmacy,
            'kpis' => $kpis,
            'charts' => $charts,
            'lowStock' => $lowStock,
            'stockThreshold' => $stockThreshold,
        ]);
    }
}
