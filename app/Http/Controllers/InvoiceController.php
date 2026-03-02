<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Factura imprimible de una venta (master-detail)
     * URL: /invoices/{sale}
     */
    public function show(int $sale)
    {
        [$saleRow, $items, $pharmacy] = $this->getInvoiceData($sale);

        // $isPdf = false (para que la vista sepa que está en pantalla)
        return view('invoices.show', [
            'sale'     => $saleRow,
            'items'    => $items,
            'pharmacy' => $pharmacy,
            'isPdf'    => false,
        ]);
    }

    /**
     * Descargar factura en PDF
     * URL: /invoices/{sale}/pdf
     */
    public function pdf(int $sale)
    {
        [$saleRow, $items, $pharmacy] = $this->getInvoiceData($sale);

        // Nombre de archivo PRO (limpio y consistente)
        $num = $saleRow->invoice_number ?? ('VTA-' . str_pad((string)$saleRow->id, 6, '0', STR_PAD_LEFT));
        $fileName = 'FACTURA_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $num) . '.pdf';

        // Render PDF desde la misma vista
        // $isPdf = true (por si querés ocultar botones en PDF sin depender solo de @media print)
        $pdf = Pdf::loadView('invoices.pdf', [
    'sale'     => $saleRow,
    'items'    => $items,
    'pharmacy' => $pharmacy,
])->setPaper('A4', 'portrait');

        return $pdf->download($fileName);
    }

    /**
     * Reutilizable (PRO): trae encabezado, detalle y farmacia, con validaciones.
     */
    private function getInvoiceData(int $sale): array
    {
        // 1) Encabezado
        $saleRow = DB::table('sales as s')
            ->leftJoin('customers as c', 'c.id', '=', 's.customer_id')
            ->leftJoin('users as u', 'u.id', '=', 's.user_id')
            ->select([
                's.id',
                's.invoice_number',
                's.customer_id',
                's.user_id',
                's.sold_at',
                's.subtotal',
                's.tax',
                's.discount',
                's.total',
                's.payment_method',
                's.status',
                's.created_at',

                'c.name as customer_name',
                'c.phone as customer_phone',
                'c.email as customer_email',

                'u.name as seller_name',
                'u.email as seller_email',
            ])
            ->where('s.id', $sale)
            ->first();

        if (!$saleRow) {
            abort(404, 'Venta no encontrada.');
        }

        // 2) Detalle
        $items = DB::table('sale_items as si')
            ->join('products as p', 'p.id', '=', 'si.product_id')
            ->select([
                'si.product_id',
                'p.name as product_name',
                'si.quantity',
                'si.unit_price',
                'si.line_total',
            ])
            ->where('si.sale_id', $saleRow->id)
            ->orderBy('p.name')
            ->get();

        if ($items->count() === 0) {
            abort(404, 'La venta no tiene items asociados.');
        }

        // 3) Datos reales de farmacia (podés mover a config/env después)
        $pharmacy = [
            'name'    => 'Farmacia Silva',
            'phone'   => '+505 8381-8798',
            'address' => 'De la escuela Germán Pomares Ordóñez 10 vrs al oeste, una cuadra al norte',
        ];

        // 4) Normalización (bonito y seguro)
        $saleRow->subtotal = round((float)($saleRow->subtotal ?? 0), 2);
        $saleRow->tax      = round((float)($saleRow->tax ?? 0), 2);
        $saleRow->discount = round((float)($saleRow->discount ?? 0), 2);
        $saleRow->total    = round((float)($saleRow->total ?? 0), 2);

        return [$saleRow, $items, $pharmacy];
    }
}
