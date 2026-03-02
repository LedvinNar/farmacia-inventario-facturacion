@extends('layouts.app')

@section('title', 'Detalle de venta')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-0">Venta #{{ $sale->id }}</h3>
        <small class="text-muted">
            {{ optional($sale->created_at)->format('Y-m-d H:i') }}
        </small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('sales.invoice', $sale) }}" class="btn btn-outline-primary">
            Factura
        </a>
        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
            Volver
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Cliente</h5>
                <div class="mb-1"><b>Nombre:</b> {{ $sale->customer->name ?? '—' }}</div>
                <div class="mb-1"><b>Teléfono:</b> {{ $sale->customer->phone ?? '—' }}</div>
                <div class="mb-1"><b>Email:</b> {{ $sale->customer->email ?? '—' }}</div>
                <div class="mb-1"><b>Dirección:</b> {{ $sale->customer->address ?? '—' }}</div>

                <hr>
                <h5 class="mb-2">Total</h5>
                <div class="display-6 fw-bold">
                    {{ number_format((float)($sale->total ?? 0), 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Items</h5>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Cantidad</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($sale->items as $it)
                            <tr>
                                <td>{{ $it->product->name ?? '—' }}</td>
                                <td class="text-end">{{ number_format((float)($it->price ?? 0), 2) }}</td>
                                <td class="text-end">{{ (int)($it->qty ?? 0) }}</td>
                                <td class="text-end fw-semibold">
                                    {{ number_format((float)(($it->price ?? 0) * ($it->qty ?? 0)), 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No hay items en esta venta.</td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">TOTAL</th>
                                <th class="text-end">{{ number_format((float)($sale->total ?? 0), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
