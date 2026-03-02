@extends('layouts.app')

@php
    $title = 'Clientes';
    $pageTitle = 'Clientes';
    $pageSubtitle = 'Gestión PRO de clientes: crear, buscar, ver, editar y eliminar.';
@endphp

@section('actions')
    <a class="btn primary" href="{{ route('core.customers.create') }}">+ Nuevo Cliente</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-head">
            <div>
                <div class="badge">Módulo PRO</div>
            </div>

            <form method="GET" action="{{ route('core.customers.index') }}" class="row" style="margin:0;">
                <div class="field" style="width: 340px;">
                    <label>Buscar</label>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Nombre / Teléfono / Email"
                    >
                    <div class="help">Tip: probá “Juan”, “8888”, “gmail”.</div>
                </div>

                <div class="field" style="width: 180px;">
                    <label>Activos</label>
                    <select name="active">
                        <option value="" {{ request('active')==='' ? 'selected' : '' }}>Todos</option>
                        <option value="1" {{ request('active')==='1' ? 'selected' : '' }}>Solo activos</option>
                        <option value="0" {{ request('active')==='0' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>

                <div style="display:flex; gap:8px; align-items:flex-end;">
                    <button class="btn" type="submit">Filtrar</button>
                    <a class="btn secondary" href="{{ route('core.customers.index') }}">Limpiar</a>
                </div>
            </form>
        </div>

        <div class="card-body" style="padding-top: 6px;">
            <table>
                <thead>
                <tr>
                    <th style="width:10%;">ID</th>
                    <th style="width:26%;">Nombre</th>
                    <th style="width:18%;">Teléfono</th>
                    <th style="width:24%;">Email</th>
                    <th style="width:12%;">Estado</th>
                    <th class="right" style="width:10%;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($customers as $c)
                    <tr>
                        <td>#{{ $c->id }}</td>
                        <td style="font-weight:800;">{{ $c->name }}</td>
                        <td>{{ $c->phone ?? '—' }}</td>
                        <td>{{ $c->email ?? '—' }}</td>
                        <td>
                            @if(($c->is_active ?? 1) == 1)
                                <span class="badge" style="border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.10);">Activo</span>
                            @else
                                <span class="badge" style="border-color: rgba(239,68,68,.35); background: rgba(239,68,68,.10);">Inactivo</span>
                            @endif
                        </td>
                        <td class="right">
                            <a class="btn secondary" href="{{ route('core.customers.show', $c->id) }}">Ver</a>
                            <a class="btn" href="{{ route('core.customers.edit', $c->id) }}">Editar</a>

                            <form method="POST" action="{{ route('core.customers.destroy', $c->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger" type="submit"
                                        onclick="return confirm('¿Eliminar cliente? Esta acción no se puede deshacer.')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="color:rgba(255,255,255,.65);">
                            No hay clientes para mostrar.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- Paginación --}}
            @if(method_exists($customers, 'links'))
                <div style="margin-top:12px;">
                    {!! $customers->withQueryString()->links() !!}
                </div>
            @endif
        </div>
    </div>
@endsection
