<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockMovementsSeeder extends Seeder
{
    public function run(): void
    {
        // Desactivar FK para limpiar seguro
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('stock_movements')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Traemos los items de compra con su compra (para saber user_id y fecha)
        $items = DB::table('purchase_items')
            ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
            ->select(
                'purchase_items.product_id',
                'purchase_items.quantity',
                'purchase_items.purchase_id',
                'purchases.user_id',
                'purchases.purchased_at'
            )
            ->get();

        if ($items->count() === 0) {
            $this->command?->warn("No hay purchase_items. Ejecutá PurchasesSeeder primero.");
            return;
        }

        foreach ($items as $it) {
            DB::table('stock_movements')->insert([
                'product_id'  => $it->product_id,
                'type'        => 'in',
                'quantity'    => $it->quantity,
                'reason'      => 'Compra de proveedor',
                'sale_id'     => null,
                'purchase_id' => $it->purchase_id,
                'user_id'     => $it->user_id,
                'moved_at'    => $it->purchased_at,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command?->info("✅ StockMovementsSeeder: movimientos de ENTRADA generados desde compras.");
    }
}
