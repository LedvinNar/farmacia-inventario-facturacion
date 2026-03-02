@extends('layouts.app')

@php
    $title = 'Editar Producto';
    $pageTitle = 'Editar Producto';
    $pageSubtitle = 'Actualizá stock, precio y datos con control y seguridad.';
@endphp

@section('actions')
    <a class="btn secondary" href="{{ route('core.products.index') }}">← Volver</a>
    <a class="btn secondary" href="{{ route('core.products.show', $product->id) }}">Ver</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-head">
            <div class="badge">Editando #{{ $product->id }}</div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('core.products.update', $product->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="field" style="width: 420px;">
                        <label>Nombre *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="field" style="width: 220px;">
                        <label>Código / SKU</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku ?? $product->code ?? '') }}">
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="field" style="width: 220px;">
                        <label>Precio (C$) *</label>
                        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', (float)($product->price ?? 0)) }}" required>
                    </div>

                    <div class="field" style="width: 220px;">
                        <label>Stock *</label>
                        <input type="number" step="1" min="0" name="stock" value="{{ old('stock', (int)($product->stock ?? 0)) }}" required>
                    </div>

                    <div class="field" style="width: 220px;">
                        <label>Estado</label>
                        <select name="is_active">
                            <option value="1" {{ old('is_active', (string)($product->is_active ?? 1))=='1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_active', (string)($product->is_active ?? 1))=='0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="field" style="width: 100%;">
                        <label>Descripción</label>
                        <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>
                </div>

                <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
                    <button class="btn primary" type="submit">Guardar Cambios</button>
                    <a class="btn secondary" href="{{ route('core.products.show', $product->id) }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
