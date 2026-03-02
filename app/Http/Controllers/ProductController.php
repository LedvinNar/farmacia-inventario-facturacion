<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /core/products
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $products = Product::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('core.products.index', compact('products', 'q'));
    }

    /**
     * GET /core/products/create
     */
    public function create()
    {
        return view('core.products.create');
    }

    /**
     * POST /core/products
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? true);

        $product = Product::create($data);

        return redirect()
            ->route('core.products.show', $product->id)
            ->with('success', '✅ Producto creado correctamente.');
    }

    /**
     * GET /core/products/{product}
     */
    public function show(Product $product)
    {
        return view('core.products.show', compact('product'));
    }

    /**
     * GET /core/products/{product}/edit
     */
    public function edit(Product $product)
    {
        return view('core.products.edit', compact('product'));
    }

    /**
     * PUT/PATCH /core/products/{product}
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? true);

        $product->update($data);

        return redirect()
            ->route('core.products.show', $product->id)
            ->with('success', '✅ Producto actualizado correctamente.');
    }

    /**
     * DELETE /core/products/{product}
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('core.products.index')
            ->with('success', '🗑️ Producto eliminado.');
    }
}
