@extends('layouts.app')

@php
    $title = 'Productos';
    $pageTitle = 'Productos';
    $pageSubtitle = 'Inventario PRO: gestión de productos, stock y precios.';
@endphp

@section('actions')
    <a class="btn primary" href="{{ route('core.products.create') }}">+ Nuevo Producto</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-head">
            <div>
                <div class="badge">Inventario PRO</div>
            </div>

            <form method="GET" action="{{ route('core.products.index') }}" class="row" style="margin:0;">
                <div class="field" style="width: 340px;">
                    <label>Buscar</label>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Nombre / Código / Marca (si aplica)"
                    >
                    <div class="help">Tip: buscá por nombre o parte del nombre.</div>
                </div>

                <div class="field" style="width: 180px;">
                    <label>Stock</label>
                    <select name="stock">
                        <option value="" {{ request('stock')==='' ? 'selected' : '' }}>Todos</option>
                        <option value="low" {{ request('stock')==='low' ? 'selected' : '' }}>Bajo stock</option>
                        <option value="out" {{ request('stock')==='out' ? 'selected' : '' }}>Sin stock</option>
                    </select>
                </div>

                <div style="display:flex; gap:8px; align-items:flex-end;">
                    <button class="btn" type="submit">Filtrar</button>
                    <a class="btn secondary" href="{{ route('core.products.index') }}">Limpiar</a>
                </div>
            </form>
        </div>

        <div class="card-body" style="padding-top: 6px;">
            <table>
                <thead>
                <tr>
                    <th style="width:8%;">ID</th>
                    <th style="width:32%;">Producto</th>
                    <th style="width:14%;">Stock</th>
                    <th style="width:16%;">Precio</th>
                    <th style="width:14%;">Estado</th>
                    <th class="right" style="width:16%;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $p)
                    @php
                        $stock = (int)($p->stock ?? 0);
                        $isActive = (int)($p->is_active ?? 1) === 1;
                    @endphp
                    <tr>
                        <td>#{{ $p->id }}</td>
                        <td style="font-weight:900;">
                            {{ $p->name ?? 'Producto' }}
                            <div class="help" style="margin-top:4px;">
                                {{ $p->sku ?? $p->code ?? '' }}
                            </div>
                        </td>
                        <td>
                            @if($stock <= 0)
                                <span class="badge" style="border-color: rgba(239,68,68,.35); background: rgba(239,68,68,.10);">
                                    Sin stock
                                </span>
                            @elseif($stock <= 5)
                                <span class="badge" style="border-color: rgba(245,158,11,.35); background: rgba(245,158,11,.10);">
                                    Bajo ({{ $stock }})
                                </span>
                            @else
                                <span class="badge" style="border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.10);">
                                    OK ({{ $stock }})
                                </span>
                            @endif
                        </td>
                        <td>
                            <b>C$</b> {{ number_format((float)($p->price ?? 0), 2) }}
                        </td>
                        <td>
                            @if($isActive)
                                <span class="badge" style="border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.10);">Activo</span>
                            @else
                                <span class="badge" style="border-color: rgba(239,68,68,.35); background: rgba(239,68,68,.10);">Inactivo</span>
                            @endif
                        </td>
                        <td class="right">
                            <a class="btn secondary" href="{{ route('core.products.show', $p->id) }}">Ver</a>
                            <a class="btn" href="{{ route('core.products.edit', $p->id) }}">Editar</a>

                            <form method="POST" action="{{ route('core.products.destroy', $p->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger" type="submit"
                                        onclick="return confirm('¿Eliminar producto? Esta acción no se puede deshacer.')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="color:rgba(255,255,255,.65);">No hay productos para mostrar.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if(method_exists($products, 'links'))
                <div style="margin-top:12px;">
                    {!! $products->withQueryString()->links() !!}
                </div>
            @endif
        </div>
    </div>
@endsection
