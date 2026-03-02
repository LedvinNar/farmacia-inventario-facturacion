<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PurchaseReportController extends Controller
{
    /**
     * Reporte Maestro-Detalle de Compra (imprimible)
     * URL: /purchases/{purchase}
     */
    public function show($purchase)
    {
        // 1) Encabezado (Compra)
        $purchaseRow = DB::table('purchases as p')
            ->leftJoin('suppliers as s', 's.id', '=', 'p.supplier_id')
            ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
            ->select([
                'p.id',
                'p.purchase_number',
                'p.supplier_id',
                'p.user_id',
                'p.purchased_at',
                'p.subtotal',
                'p.tax',
                'p.discount',
                'p.total',
                'p.status',
                'p.created_at',

                // Proveedor
                's.name as supplier_name',
                's.phone as supplier_phone',
                's.email as supplier_email',

                // Usuario/Responsable
                'u.name as buyer_name',
                'u.email as buyer_email',
            ])
            ->where('p.id', $purchase)
            ->first();

        if (!$purchaseRow) {
            abort(404, 'Compra no encontrada.');
        }

        // 2) Detalle (Items)
        $items = DB::table('purchase_items as pi')
            ->join('products as pr', 'pr.id', '=', 'pi.product_id')
            ->select([
                'pi.product_id',
                'pr.name as product_name',
                'pi.quantity',
                'pi.unit_cost',
                'pi.line_total',
            ])
            ->where('pi.purchase_id', $purchaseRow->id)
            ->orderBy('pr.name')
            ->get();

        // 3) Datos de la farmacia
        $pharmacy = [
            'name'    => 'Silva',
            'phone'   => '+50583818798',
            'address' => 'De la escuela Germán Pomares Ordóñez 10 vrs al oeste una cuadra al Norte',
        ];

        return view('purchases.show', [
            'purchase' => $purchaseRow,
            'items'    => $items,
            'pharmacy' => $pharmacy,
        ]);
    }
}
