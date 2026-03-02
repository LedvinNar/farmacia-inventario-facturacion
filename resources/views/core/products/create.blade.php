@extends('layouts.app')

@php
    $title = 'Nuevo Producto';
    $pageTitle = 'Nuevo Producto';
    $pageSubtitle = 'Registro profesional de producto para inventario y ventas.';
@endphp

@section('actions')
    <a class="btn secondary" href="{{ route('core.products.index') }}">← Volver</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-head">
            <div class="badge">Formulario PRO</div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('core.products.store') }}">
                @csrf

                <div class="row">
                    <div class="field" style="width: 420px;">
                        <label>Nombre *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej: Paracetamol 500mg">
                    </div>

                    <div class="field" style="width: 220px;">
                        <label>Código / SKU</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" placeholder="Ej: MED-001">
                        <div class="help">Opcional, pero recomendado.</div>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="field" style="width: 220px;">
                        <label>Precio (C$) *</label>
                        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', '0.00') }}" required>
                    </div>

                    <div class="field" style="width: 220px;">
                        <label>Stock inicial *</label>
                        <input type="number" step="1" min="0" name="stock" value="{{ old('stock', 0) }}" required>
                    </div>

                    <div class="field" style="width: 220px;">
                        <label>Estado</label>
                        <select name="is_active">
                            <option value="1" {{ old('is_active','1')=='1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_active')=='0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="field" style="width: 100%;">
                        <label>Descripción</label>
                        <textarea name="description" placeholder="Opcional (presentación, indicaciones, etc.)">{{ old('description') }}</textarea>
                        <div class="help">Esto se puede mostrar en reportes o ficha del producto.</div>
                    </div>
                </div>

                <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
                    <button class="btn primary" type="submit">Guardar Producto</button>
                    <a class="btn secondary" href="{{ route('core.products.index') }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
