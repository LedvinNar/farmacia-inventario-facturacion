<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * GET /core/customers
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $customers = Customer::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('core.customers.index', compact('customers', 'q'));
    }

    /**
     * GET /core/customers/create
     */
    public function create()
    {
        return view('core.customers.create');
    }

    /**
     * POST /core/customers
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:50'],
            'email'     => ['nullable', 'email', 'max:255'],
            'address'   => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? true);

        $customer = Customer::create($data);

        return redirect()
            ->route('core.customers.show', $customer->id)
            ->with('success', '✅ Cliente creado correctamente.');
    }

    /**
     * GET /core/customers/{customer}
     */
    public function show(Customer $customer)
    {
        return view('core.customers.show', compact('customer'));
    }

    /**
     * GET /core/customers/{customer}/edit
     */
    public function edit(Customer $customer)
    {
        return view('core.customers.edit', compact('customer'));
    }

    /**
     * PUT/PATCH /core/customers/{customer}
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:50'],
            'email'     => ['nullable', 'email', 'max:255'],
            'address'   => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? true);

        $customer->update($data);

        return redirect()
            ->route('core.customers.show', $customer->id)
            ->with('success', '✅ Cliente actualizado correctamente.');
    }

    /**
     * DELETE /core/customers/{customer}
     */
    public function destroy(Customer $customer)
    {
        // Soft delete sería lo ideal, pero por ahora eliminamos físico si aplica.
        $customer->delete();

        return redirect()
            ->route('core.customers.index')
            ->with('success', '🗑️ Cliente eliminado.');
    }
}
