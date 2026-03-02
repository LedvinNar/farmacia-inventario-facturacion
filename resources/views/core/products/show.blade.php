@extends('layouts.app')

@php
    $title = 'Detalle de Producto';
    $pageTitle = 'Detalle de Producto';
    $pageSubtitle = 'Ficha del producto con stock, precio y estado.';
@endphp

@section('actions')
    <a class="btn secondary" href="{{ route('core.products.index') }}">← Volver</a>
    <a class="btn" href="{{ route('core.products.edit', $product->id) }}">Editar</a>
@endsection

@section('content')
    @php
        $stock = (int)($product->stock ?? 0);
        $isActive = (int)($product->is_active ?? 1) === 1;
    @endphp

    <div class="grid" style="grid-template-columns: 1fr 1fr;">
        <div class="card">
            <div class="card-head">
                <div style="display:flex; gap:10px; align-items:center;">
                    <span class="badge">Producto #{{ $product->id }}</span>
                    @if($isActive)
                        <span class="badge" style="border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.10);">Activo</span>
                    @else
                        <span class="badge" style="border-color: rgba(239,68,68,.35); background: rgba(239,68,68,.10);">Inactivo</span>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div style="font-size:18px; font-weight:900;">{{ $product->name ?? 'Producto' }}</div>

                <div style="margin-top:10px; color: rgba(255,255,255,.80); line-height:1.7;">
                    <div><b>SKU:</b> {{ $product->sku ?? $product->code ?? '—' }}</div>
                    <div><b>Precio:</b> C$ {{ number_format((float)($product->price ?? 0), 2) }}</div>
                    <div><b>Stock:</b> {{ $stock }}</div>
                </div>

                @if(!empty($product->description))
                    <div style="margin-top:10px;">
                        <div class="badge">Descripción</div>
                        <div style="margin-top:8px; color: rgba(255,255,255,.78); line-height:1.7;">
                            {{ $product->description }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="badge">Acciones</div>
            </div>
            <div class="card-body">
                <div class="help">Recomendación pro: no eliminar si ya ha tenido ventas; mejor desactivar.</div>

                <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
                    <a class="btn primary" href="{{ route('core.products.edit', $product->id) }}">Editar</a>

                    <form method="POST" action="{{ route('core.products.destroy', $product->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn danger" type="submit"
                                onclick="return confirm('¿Eliminar producto? Esta acción no se puede deshacer.')">
                            Eliminar
                        </button>
                    </form>
                </div>

                <div style="margin-top:14px;">
                    @if($stock <= 0)
                        <span class="badge" style="border-color: rgba(239,68,68,.35); background: rgba(239,68,68,.10);">Sin stock</span>
                    @elseif($stock <= 5)
                        <span class="badge" style="border-color: rgba(245,158,11,.35); background: rgba(245,158,11,.10);">Bajo stock</span>
                    @else
                        <span class="badge" style="border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.10);">Stock OK</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
