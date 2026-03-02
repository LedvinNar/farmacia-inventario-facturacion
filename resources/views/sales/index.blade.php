@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-0">Ventas</h3>
        <small class="text-muted">Gestión y consulta de ventas registradas.</small>
    </div>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">
        + Nueva venta
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger" style="white-space: pre-line;">{{ session('error') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>
                            {{ optional($sale->created_at)->format('Y-m-d H:i') }}
                        </td>
                        <td>
                            {{ $sale->customer->name ?? '—' }}
                            <div class="text-muted small">
                                {{ $sale->customer->phone ?? '' }}
                            </div>
                        </td>
                        <td class="text-end fw-semibold">
                            {{ number_format((float)($sale->total ?? 0), 2) }}
                        </td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('sales.show', $sale) }}">
                                Ver
                            </a>

                            <a class="btn btn-sm btn-outline-primary" href="{{ route('sales.invoice', $sale) }}">
                                Factura
                            </a>

                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta venta? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No hay ventas registradas todavía.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $sales->links() ?? '' }}
        </div>
    </div>
</div>
@endsection
