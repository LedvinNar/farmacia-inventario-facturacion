<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SalesSeeder extends Seeder
{
    /**
     * Genera ventas con items y además registra SALIDAS en stock_movements.
     * Reglas:
     * - Usa clientes existentes.
     * - Usa productos existentes.
     * - Valida stock antes de vender.
     * - Calcula subtotal, tax, discount y total.
     * - Usa columnas reales de TU BD: invoice_number, payment_method, status.
     */
    public function run(): void
    {
        // 1) Validación básica: debe existir data base
        $customersCount = DB::table('customers')->count();
        $productsCount  = DB::table('products')->count();
        $usersCount     = DB::table('users')->count();

        if ($customersCount === 0) {
            $this->command?->warn('⚠ No hay clientes. Ejecutá primero: php artisan db:seed --class=CustomersSeeder');
            return;
        }

        if ($productsCount === 0) {
            $this->command?->warn('⚠ No hay productos. Ejecutá primero: php artisan db:seed --class=ProductsSeeder');
            return;
        }

        if ($usersCount === 0) {
            $this->command?->warn('⚠ No hay usuarios. Ejecutá primero: php artisan db:seed --class=UserSeeder');
            return;
        }

        // 2) Limpieza segura (sin TRUNCATE para evitar FK error)
        // Primero hijos -> luego padres
        DB::table('sale_items')->delete();
        DB::table('sales')->delete();

        // 3) Traer datos base
        $customerIds = DB::table('customers')->pluck('id')->toArray();
        $userIds     = DB::table('users')->pluck('id')->toArray();

        // Productos con stock
        $products = DB::table('products')
            ->select('id', 'name', 'sale_price', 'stock')
            ->get()
            ->map(function ($p) {
                $p->sale_price = is_null($p->sale_price) ? 0 : (float)$p->sale_price;
                $p->stock      = is_null($p->stock) ? 0 : (int)$p->stock;
                return $p;
            })
            ->keyBy('id');

        // 4) Configuración (podés subir si querés más “pro”)
        $salesToCreate = 25;
        $minItems = 1;
        $maxItems = 5;

        $now = Carbon::now();

        $createdSales = 0;
        $createdItems = 0;
        $skippedSales = 0;

        DB::beginTransaction();
        try {

            for ($i = 0; $i < $salesToCreate; $i++) {

                $customerId = $customerIds[array_rand($customerIds)];
                $userId     = $userIds[array_rand($userIds)];

                $itemsCount = rand($minItems, $maxItems);

                // seleccionar productos aleatorios
                $productPool = $products->keys()
                    ->shuffle()
                    ->take(min($itemsCount * 2, $products->count()))
                    ->toArray();

                $saleItems = [];
                $subtotal = 0;

                foreach ($productPool as $pid) {
                    if (count($saleItems) >= $itemsCount) break;

                    $product = $products[$pid];

                    // si no hay stock, saltar
                    if ($product->stock <= 0) continue;

                    $qty = rand(1, 3);
                    if ($qty > $product->stock) {
                        $qty = $product->stock;
                    }
                    if ($qty <= 0) continue;

                    $unitPrice = $product->sale_price > 0 ? $product->sale_price : rand(20, 150);
                    $lineTotal = round($unitPrice * $qty, 2);

                    $saleItems[] = [
                        'product_id' => $pid,
                        'quantity'   => $qty,
                        'unit_price' => $unitPrice,
                        'line_total' => $lineTotal,
                    ];

                    $subtotal += $lineTotal;
                }

                // si no hay items, saltar venta
                if (count($saleItems) === 0) {
                    $skippedSales++;
                    continue;
                }

                // tax y descuento
                $taxRate = 0.15;
                $tax = round($subtotal * $taxRate, 2);

                $discountOptions = [0, 0.05, 0.10];
                $discountRate = $discountOptions[array_rand($discountOptions)];
                $discount = round($subtotal * $discountRate, 2);

                $total = round(($subtotal + $tax) - $discount, 2);

                // ✅ TU BD usa invoice_number (NO sale_number)
                $invoiceNumber = 'VTA-' . strtoupper(Str::random(8));

                // ✅ TU BD tiene payment_method
                $paymentMethod = ['efectivo', 'tarjeta'][rand(0, 1)];

                // ✅ En tu captura se mira “completada” como valor típico
                $status = 'completada';

                // 5) Insertar venta
                $saleId = DB::table('sales')->insertGetId([
                    'invoice_number' => $invoiceNumber,
                    'customer_id'    => $customerId,
                    'user_id'        => $userId,
                    'sold_at'        => $now->copy()->subDays(rand(0, 30))->subMinutes(rand(0, 1440)),
                    'subtotal'       => $subtotal,
                    'tax'            => $tax,
                    'discount'       => $discount,
                    'total'          => $total,
                    'payment_method' => $paymentMethod,
                    'status'         => $status,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ]);

                // 6) Insertar items + stock_movements OUT + descontar stock
                foreach ($saleItems as $it) {

                    DB::table('sale_items')->insert([
                        'sale_id'    => $saleId,
                        'product_id' => $it['product_id'],
                        'quantity'   => $it['quantity'],
                        'unit_price' => $it['unit_price'],
                        'line_total' => $it['line_total'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    DB::table('stock_movements')->insert([
                        'product_id'  => $it['product_id'],
                        'type'        => 'out',
                        'quantity'    => $it['quantity'],
                        'reason'      => 'Venta',
                        'sale_id'     => $saleId,
                        'purchase_id' => null,
                        'user_id'     => $userId,
                        'moved_at'    => $now,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ]);

                    DB::table('products')
                        ->where('id', $it['product_id'])
                        ->update([
                            'stock' => DB::raw('GREATEST(stock - ' . (int)$it['quantity'] . ', 0)'),
                            'updated_at' => $now,
                        ]);

                    // actualizar stock local
                    $products[$it['product_id']]->stock -= $it['quantity'];

                    $createdItems++;
                }

                $createdSales++;
            }

            DB::commit();

            $this->command?->info("✅ SalesSeeder: {$createdSales} ventas creadas con {$createdItems} items. (Saltadas por stock: {$skippedSales})");

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
