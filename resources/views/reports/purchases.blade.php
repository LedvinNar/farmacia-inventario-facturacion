<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root { --border:#e5e7eb; --muted:#6b7280; }
        body { font-family: Arial, Helvetica, sans-serif; margin: 24px; color:#111827; }
        .top { display:flex; justify-content:space-between; gap:20px; align-items:flex-start; }
        .brand h1 { margin:0; font-size: 22px; }
        .brand .muted { color: var(--muted); font-size: 12px; line-height: 1.4; }
        .box { border:1px solid var(--border); border-radius:10px; padding:12px; }
        .filters { margin-top: 14px; display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap; }
        label { font-size: 12px; color: var(--muted); display:block; margin-bottom:4px; }
        input { padding:10px; border:1px solid var(--border); border-radius:10px; }
        .btn { border:1px solid var(--border); background:#111827; color:#fff; padding:10px 12px; border-radius:10px; cursor:pointer; text-decoration:none; display:inline-block; }
        .btn.secondary { background:#fff; color:#111827; }
        table { width:100%; border-collapse:collapse; margin-top: 14px; }
        th, td { padding:10px; border-bottom:1px solid var(--border); text-align:left; }
        th { font-size:12px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
        .right { text-align:right; }
        .footer { margin-top: 18px; font-size: 12px; color: var(--muted); }

        @media print {
            .filters { display:none; }
            body { margin: 0; }
            .box { border: none; padding:0; }
        }
    </style>
</head>
<body>

<div class="top">
    <div class="brand">
        <h1>Farmacia {{ $pharmacy['name'] }}</h1>
        <div class="muted">
            Tel: {{ $pharmacy['phone'] }}<br>
            Dirección: {{ $pharmacy['address'] }}
        </div>
    </div>

    <div class="box" style="min-width: 320px;">
        <b>Reporte de Compras</b><br>
        <div class="muted" style="margin-top:6px;">
            <b>Rango:</b> {{ $from }} a {{ $to }}<br>
            <b>Registros:</b> {{ $totals['count'] }}<br>
            <b>Total comprado:</b> C$ {{ number_format($totals['total'], 2) }}
        </div>
    </div>
</div>

<form class="filters" method="GET" action="{{ route('reports.purchases') }}">
    <div>
        <label>Desde</label>
        <input type="date" name="from" value="{{ $from }}">
    </div>
    <div>
        <label>Hasta</label>
        <input type="date" name="to" value="{{ $to }}">
    </div>
    <button class="btn" type="submit">Filtrar</button>

    <button class="btn secondary" type="button" onclick="window.print()">Imprimir</button>

    <a class="btn" href="{{ route('reports.purchases.export', ['from' => $from, 'to' => $to]) }}">
        Exportar Excel
    </a>

    <a class="btn secondary" href="{{ url()->previous() }}">Volver</a>
</form>

<table>
    <thead>
    <tr>
        <th>Compra</th>
        <th>Fecha</th>
        <th>Proveedor</th>
        <th>Responsable</th>
        <th class="right">Total</th>
        <th>Acción</th>
    </tr>
    </thead>
    <tbody>
    @forelse($purchases as $p)
        <tr>
            <td>{{ $p->purchase_number ?? ('CMP-' . $p->id) }}</td>
            <td>{{ \Carbon\Carbon::parse($p->purchased_at)->format('d/m/Y H:i') }}</td>
            <td>{{ $p->supplier_name ?? 'N/D' }}</td>
            <td>{{ $p->buyer_name ?? 'N/D' }}</td>
            <td class="right">C$ {{ number_format((float)$p->total, 2) }}</td>
            <td>
                <a class="btn secondary" href="{{ route('purchases.show', $p->id) }}">Ver compra</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="muted">No hay compras en ese rango.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="footer">
    Totales del rango:
    Subtotal C$ {{ number_format($totals['subtotal'], 2) }},
    Impuesto C$ {{ number_format($totals['tax'], 2) }},
    Descuento C$ {{ number_format($totals['discount'], 2) }},
    Total C$ {{ number_format($totals['total'], 2) }}.
</div>

</body>
</html>
