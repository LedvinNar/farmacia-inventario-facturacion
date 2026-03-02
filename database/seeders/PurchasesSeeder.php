<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchasesSeeder extends Seeder
{
    public function run(): void
    {
        // ========= 1) DESACTIVAR LLAVES FORÁNEAS (evita error 1701) =========
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // ========= 2) TRUNCAR EN ORDEN CORRECTO (HIJAS -> PADRE) =========
        DB::table('purchase_items')->truncate();
        DB::table('purchases')->truncate();

        // ========= 3) ACTIVAR LLAVES FORÁNEAS =========
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ========= 4) VALIDACIONES (para evitar null->id) =========
        $supplierIds = DB::table('suppliers')->pluck('id')->toArray();
        $userIds     = DB::table('users')->pluck('id')->toArray();
        $products    = DB::table('products')->select('id', 'purchase_price')->get();

        if (count($supplierIds) === 0) {
            $this->command?->error("❌ No hay proveedores en suppliers. Ejecutá SuppliersSeeder.");
            return;
        }

        if (count($userIds) === 0) {
            $this->command?->error("❌ No hay usuarios en users. Ejecutá UserSeeder.");
            return;
        }

        if ($products->count() === 0) {
            $this->command?->error("❌ No hay productos en products. Ejecutá ProductsSeeder.");
            return;
        }

        // ========= 5) CONFIGURACIÓN =========
        $minPurchases = 25;            // 25 compras (más pro que 20)
        $minItems = 2;                 // mínimo 2 items por compra
        $maxItems = 5;                 // máximo 5 items por compra
        $statuses = ['completed', 'completed', 'completed', 'pending']; // mayoría completed

        // ========= 6) CREAR COMPRAS + ITEMS =========
        for ($i = 1; $i <= $minPurchases; $i++) {

            $supplierId = $supplierIds[array_rand($supplierIds)];
            $userId     = $userIds[array_rand($userIds)];

            // Fecha entre hoy y 90 días atrás (horario laboral)
            $date = Carbon::now()->subDays(rand(0, 90))->setTime(rand(8, 17), rand(0, 59), 0);

            $purchaseNumber = 'COMP-' . $date->format('Ymd') . '-' . str_pad((string)$i, 4, '0', STR_PAD_LEFT);
            $status = $statuses[array_rand($statuses)];

            // Elegir productos sin repetir
            $itemsCount = rand($minItems, $maxItems);
            $picked = $products->shuffle()->take(min($itemsCount, $products->count()));

            $subtotal = 0;
            $itemsData = [];

            foreach ($picked as $p) {
                $qty = rand(3, 20);

                $unitCost = (float) ($p->purchase_price ?? 0);
                if ($unitCost <= 0) {
                    $unitCost = rand(20, 120); // respaldo si no trae precio compra
                }

                $lineTotal = $qty * $unitCost;
                $subtotal += $lineTotal;

                $itemsData[] = [
                    'product_id' => $p->id,
                    'quantity'   => $qty,
                    'unit_cost'  => round($unitCost, 2),
                    'line_total' => round($lineTotal, 2),
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }

            $tax = round($subtotal * 0.15, 2);
            $discount = round($subtotal * (rand(0, 8) / 100), 2); // 0% a 8%
            $total = round(($subtotal + $tax) - $discount, 2);

            // Insertar compra
            $purchaseId = DB::table('purchases')->insertGetId([
                'purchase_number' => $purchaseNumber,
                'supplier_id'     => $supplierId,
                'user_id'         => $userId,
                'purchased_at'    => $date,
                'subtotal'        => round($subtotal, 2),
                'tax'             => $tax,
                'discount'        => $discount,
                'total'           => $total,
                'status'          => $status,
                'created_at'      => $date,
                'updated_at'      => $date,
            ]);

            // Insertar items (detalle)
            foreach ($itemsData as &$row) {
                $row['purchase_id'] = $purchaseId;
            }
            unset($row);

            DB::table('purchase_items')->insert($itemsData);
        }

        $this->command?->info("✅ PurchasesSeeder: $minPurchases compras creadas con items.");
    }
}
