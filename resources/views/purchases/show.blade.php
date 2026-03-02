<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra {{ $purchase->purchase_number ?? ('CMP-' . $purchase->id) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root { --border:#e5e7eb; --muted:#6b7280; }
        body { font-family: Arial, Helvetica, sans-serif; margin: 24px; color:#111827; }
        .top { display:flex; justify-content:space-between; gap:20px; align-items:flex-start; }
        .brand h1 { margin:0; font-size: 22px; }
        .brand .muted { color: var(--muted); font-size: 12px; line-height: 1.4; }
        .box { border:1px solid var(--border); border-radius:10px; padding:12px; }
        .grid { display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-top: 12px; }
        .title { font-weight:700; margin-bottom:6px; }
        table { width:100%; border-collapse:collapse; margin-top: 14px; }
        th, td { padding:10px; border-bottom:1px solid var(--border); text-align:left; }
        th { font-size:12px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
        .right { text-align:right; }
        .totals { margin-top: 12px; display:flex; justify-content:flex-end; }
        .totals table { width: 320px; }
        .totals td { border-bottom:none; padding:6px 10px; }
        .totals tr:last-child td { font-weight: 800; border-top: 1px solid var(--border); padding-top: 10px; }
        .actions { margin-top: 16px; display:flex; gap:10px; }
        .btn { border:1px solid var(--border); background:#111827; color:#fff; padding:10px 12px; border-radius:10px; cursor:pointer; text-decoration:none; display:inline-block; }
        .btn.secondary { background:#fff; color:#111827; }
        .footer { margin-top: 18px; font-size: 12px; color: var(--muted); }

        @media print {
            .actions { display:none; }
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

    <div class="box" style="min-width: 280px;">
        <div class="title">Compra</div>
        <div class="muted">
            <b>N°:</b> {{ $purchase->purchase_number ?? ('CMP-' . $purchase->id) }}<br>
            <b>Fecha:</b> {{ \Carbon\Carbon::parse($purchase->purchased_at)->format('d/m/Y H:i') }}<br>
            <b>Estado:</b> {{ $purchase->status ?? 'completada' }}
        </div>
    </div>
</div>

<div class="grid">
    <div class="box">
        <div class="title">Proveedor</div>
        <div class="muted">
            <b>Nombre:</b> {{ $purchase->supplier_name ?? 'N/D' }}<br>
            <b>Teléfono:</b> {{ $purchase->supplier_phone ?? 'N/D' }}<br>
            <b>Email:</b> {{ $purchase->supplier_email ?? 'N/D' }}
        </div>
    </div>

    <div class="box">
        <div class="title">Responsable</div>
        <div class="muted">
            <b>Nombre:</b> {{ $purchase->buyer_name ?? 'N/D' }}<br>
            <b>Email:</b> {{ $purchase->buyer_email ?? 'N/D' }}
        </div>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th style="width:45%;">Producto</th>
        <th class="right" style="width:15%;">Cant.</th>
        <th class="right" style="width:20%;">Costo</th>
        <th class="right" style="width:20%;">Total</th>
    </tr>
    </thead>
    <tbody>
    @forelse($items as $it)
        <tr>
            <td>{{ $it->product_name }}</td>
            <td class="right">{{ number_format((float)$it->quantity, 0) }}</td>
            <td class="right">C$ {{ number_format((float)$it->unit_cost, 2) }}</td>
            <td class="right">C$ {{ number_format((float)$it->line_total, 2) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="muted">No hay items en esta compra.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="totals">
    <table>
        <tr>
            <td class="muted">Subtotal</td>
            <td class="right">C$ {{ number_format((float)$purchase->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td class="muted">Impuesto</td>
            <td class="right">C$ {{ number_format((float)$purchase->tax, 2) }}</td>
        </tr>
        <tr>
            <td class="muted">Descuento</td>
            <td class="right">- C$ {{ number_format((float)$purchase->discount, 2) }}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td class="right">C$ {{ number_format((float)$purchase->total, 2) }}</td>
        </tr>
    </table>
</div>

<div class="actions">
    <button class="btn" onclick="window.print()">Imprimir</button>
    <a class="btn secondary" href="javascript:history.back()">Volver</a>
</div>

<div class="footer">
    Documento generado por el Sistema de Inventario y Facturación - Farmacia {{ $pharmacy['name'] }}.
</div>

</body>
</html>
