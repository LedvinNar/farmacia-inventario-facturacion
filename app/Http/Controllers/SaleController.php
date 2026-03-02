<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * GET /sales
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $sales = Sale::query()
            ->with(['customer'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('invoice_number', 'like', "%{$q}%")
                      ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', "%{$q}%"));
                });
            })
            ->orderByDesc('sold_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('sales.index', compact('sales', 'q'));
    }

    /**
     * GET /sales/create
     */
    public function create()
{
    $customers = \App\Models\Customer::orderBy('name')->get();

    $products = \App\Models\Product::where('is_active', 1)
        ->orderBy('name')
        ->get(['id','name','price','stock']);

    // ✅ PRO: preparamos JSON aquí (NO en Blade)
    $productsJson = $products->map(function ($p) {
        return [
            'id'    => $p->id,
            'name'  => $p->name,
            'price' => (float) ($p->price ?? 0),
            'stock' => (float) ($p->stock ?? 0),
        ];
    })->values();

    return view('sales.create', compact(
        'customers',
        'products',
        'productsJson'
    ));
}

    /**
     * POST /sales
     * Crea venta + items + descuenta stock (TODO en transacción)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],

            // items[]: [{product_id, quantity}]
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity'   => ['required', 'integer', 'min:1'],

            'payment_method' => ['nullable', 'string', 'max:50'],
            'discount'       => ['nullable', 'numeric', 'min:0'],
            'tax'            => ['nullable', 'numeric', 'min:0'],
        ]);

        $paymentMethod = $data['payment_method'] ?? 'efectivo';
        $discount      = (float)($data['discount'] ?? 0);
        $tax           = (float)($data['tax'] ?? 0);

        try {
            $sale = DB::transaction(function () use ($data, $paymentMethod, $discount, $tax) {

                // Bloqueamos productos que vamos a usar (para stock seguro)
                $productIds = collect($data['items'])->pluck('product_id')->unique()->values();

                $products = Product::query()
                    ->whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $subtotal = 0;

                // Validación de stock + cálculo subtotal
                foreach ($data['items'] as $row) {
                    $p = $products->get($row['product_id']);
                    $qty = (int)$row['quantity'];

                    if (!$p) {
                        throw new \RuntimeException("Producto no encontrado: ID {$row['product_id']}");
                    }
                    if ((int)$p->stock < $qty) {
                        throw new \RuntimeException("Stock insuficiente para {$p->name}. Disponible: {$p->stock}, solicitado: {$qty}");
                    }

                    $subtotal += ((float)$p->price) * $qty;
                }

                $total = max(0, ($subtotal + $tax) - $discount);

                // Crear venta
                $sale = Sale::create([
                    'customer_id'    => $data['customer_id'] ?? null,
                    'invoice_number' => null, // lo generamos después con el ID
                    'subtotal'       => $subtotal,
                    'tax'            => $tax,
                    'discount'       => $discount,
                    'total'          => $total,
                    'payment_method' => $paymentMethod,
                    'sold_at'        => now(),
                ]);

                // Generar número factura pro
                $sale->invoice_number = 'VTA-' . str_pad((string)$sale->id, 6, '0', STR_PAD_LEFT);
                $sale->save();

                // Crear items + descontar stock
                foreach ($data['items'] as $row) {
                    $p = $products->get($row['product_id']);
                    $qty = (int)$row['quantity'];
                    $price = (float)$p->price;
                    $lineSubtotal = $price * $qty;

                    SaleItem::create([
                        'sale_id'    => $sale->id,
                        'product_id' => $p->id,
                        'quantity'   => $qty,
                        'price'      => $price,
                        'subtotal'   => $lineSubtotal,
                    ]);

                    $p->stock = (int)$p->stock - $qty;
                    $p->save();
                }

                return $sale;
            });

            return redirect()
                ->route('sales.show', $sale->id)
                ->with('success', '✅ Venta creada correctamente.');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', '⚠️ No se pudo crear la venta: ' . $e->getMessage());
        }
    }

    /**
     * GET /sales/{sale}
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer', 'items.product']);

        return view('sales.show', compact('sale'));
    }

    /**
     * DELETE /sales/{sale}
     * (Opcional: devolver stock al eliminar)
     */
    public function destroy(Sale $sale)
    {
        try {
            DB::transaction(function () use ($sale) {
                $sale->load('items.product');

                // devolvemos stock
                foreach ($sale->items as $it) {
                    if ($it->product) {
                        $it->product->stock = (int)$it->product->stock + (int)$it->quantity;
                        $it->product->save();
                    }
                }

                $sale->items()->delete();
                $sale->delete();
            });

            return redirect()
                ->route('sales.index')
                ->with('success', '🗑️ Venta eliminada y stock devuelto.');
        } catch (\Throwable $e) {
            return back()->with('error', '⚠️ No se pudo eliminar: ' . $e->getMessage());
        }
    }

    /**
     * GET /sales/{sale}/invoice
     * Atajo: manda a la factura existente
     */
    public function invoice(Sale $sale)
    {
        return redirect()->route('invoices.show', ['sale' => $sale->id]);
    }
}
