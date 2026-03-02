@extends('layouts.app')

@php
    $title = 'Nuevo Cliente';
    $pageTitle = 'Nuevo Cliente';
    $pageSubtitle = 'Registro profesional de cliente para ventas y facturación.';
@endphp

@section('actions')
    <a class="btn secondary" href="{{ route('core.customers.index') }}">← Volver</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-head">
            <div class="badge">Formulario PRO</div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('core.customers.store') }}">
                @csrf

                <div class="row">
                    <div class="field">
                        <label>Nombre *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej: Juan Pérez">
                    </div>

                    <div class="field">
                        <label>Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Ej: 88881234">
                    </div>

                    <div class="field" style="width:320px;">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Ej: cliente@gmail.com">
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="field" style="width: 100%;">
                        <label>Dirección</label>
                        <textarea name="address" placeholder="Ej: Cristo Rey, León, Nicaragua">{{ old('address') }}</textarea>
                        <div class="help">La dirección ayuda en reportes o entrega.</div>
                    </div>
                </div>

                <div class="row" style="margin-top:12px;">
                    <div class="field" style="width: 220px;">
                        <label>Estado</label>
                        <select name="is_active">
                            <option value="1" {{ old('is_active','1')=='1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_active')=='0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
                    <button class="btn primary" type="submit">Guardar Cliente</button>
                    <a class="btn secondary" href="{{ route('core.customers.index') }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
