@extends('layouts.app')

@php
    $title = 'Editar Cliente';
    $pageTitle = 'Editar Cliente';
    $pageSubtitle = 'Actualizá información del cliente con control y seguridad.';
@endphp

@section('actions')
    <a class="btn secondary" href="{{ route('core.customers.index') }}">← Volver</a>
    <a class="btn secondary" href="{{ route('core.customers.show', $customer->id) }}">Ver</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-head">
            <div style="display:flex; gap:10px; align-items:center;">
                <span class="badge">Editando #{{ $customer->id }}</span>
                @if(($customer->is_active ?? 1) == 1)
                    <span class="badge" style="border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.10);">Activo</span>
                @else
                    <span class="badge" style="border-color: rgba(239,68,68,.35); background: rgba(239,68,68,.10);">Inactivo</span>
                @endif
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('core.customers.update', $customer->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="field">
                        <label>Nombre *</label>
                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" required>
                    </div>

                    <div class="field">
                        <label>Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}">
                    </div>

                    <div class="field" style="width:320px;">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}">
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="field" style="width:100%;">
                        <label>Dirección</label>
                        <textarea name="address">{{ old('address', $customer->address) }}</textarea>
                    </div>
                </div>

                <div class="row" style="margin-top:12px;">
                    <div class="field" style="width: 220px;">
                        <label>Estado</label>
                        <select name="is_active">
                            <option value="1" {{ old('is_active', (string)($customer->is_active ?? 1))=='1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_active', (string)($customer->is_active ?? 1))=='0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
                    <button class="btn primary" type="submit">Guardar Cambios</button>
                    <a class="btn secondary" href="{{ route('core.customers.show', $customer->id) }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
