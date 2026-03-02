@extends('layouts.app')

@php
    $title = 'Detalle de Cliente';
    $pageTitle = 'Detalle de Cliente';
    $pageSubtitle = 'Información completa del cliente (nivel sistema real).';
@endphp

@section('actions')
    <a class="btn secondary" href="{{ route('core.customers.index') }}">← Volver</a>
    <a class="btn" href="{{ route('core.customers.edit', $customer->id) }}">Editar</a>
@endsection

@section('content')
    <div class="grid" style="grid-template-columns: 1fr 1fr;">
        <div class="card">
            <div class="card-head">
                <div style="display:flex; gap:10px; align-items:center;">
                    <span class="badge">Cliente #{{ $customer->id }}</span>
                    @if(($customer->is_active ?? 1) == 1)
                        <span class="badge" style="border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.10);">Activo</span>
                    @else
                        <span class="badge" style="border-color: rgba(239,68,68,.35); background: rgba(239,68,68,.10);">Inactivo</span>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div style="font-size:18px; font-weight:900;">{{ $customer->name }}</div>
                <div style="margin-top:10px; color: rgba(255,255,255,.80); line-height:1.7;">
                    <div><b>Teléfono:</b> {{ $customer->phone ?? '—' }}</div>
                    <div><b>Email:</b> {{ $customer->email ?? '—' }}</div>
                    <div><b>Dirección:</b> {{ $customer->address ?? '—' }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="badge">Acciones</div>
            </div>
            <div class="card-body">
                <div class="help">
                    Desde aquí podés editar o eliminar (con confirmación).
                </div>

                <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
                    <a class="btn primary" href="{{ route('core.customers.edit', $customer->id) }}">Editar</a>

                    <form method="POST" action="{{ route('core.customers.destroy', $customer->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn danger" type="submit"
                                onclick="return confirm('¿Eliminar cliente? Esta acción no se puede deshacer.')">
                            Eliminar
                        </button>
                    </form>
                </div>

                <div style="margin-top:14px;" class="help">
                    <b>Nota:</b> Para un sistema real, en vez de eliminar, se suele “desactivar” para no perder historial.
                </div>
            </div>
        </div>
    </div>
@endsection
