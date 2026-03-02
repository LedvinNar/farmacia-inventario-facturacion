<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchasesReportExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = Carbon::parse($from)->startOfDay();
        $this->to   = Carbon::parse($to)->endOfDay();
    }

    public function collection()
    {
        return DB::table('purchases as p')
            ->leftJoin('suppliers as s', 's.id', '=', 'p.supplier_id')
            ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
            ->select([
                'p.purchase_number',
                'p.purchased_at',
                DB::raw("COALESCE(s.name, 'N/D') as supplier"),
                DB::raw("COALESCE(u.name, 'N/D') as buyer"),
                'p.subtotal',
                'p.tax',
                'p.discount',
                'p.total',
                'p.status',
            ])
            ->whereBetween('p.purchased_at', [$this->from, $this->to])
            ->orderByDesc('p.purchased_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Compra',
            'Fecha',
            'Proveedor',
            'Responsable',
            'Subtotal',
            'Impuesto',
            'Descuento',
            'Total',
            'Estado',
        ];
    }
}
