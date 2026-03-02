<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $sale->invoice_number ?? ('VTA-' . $sale->id) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        use Carbon\Carbon;

        // Helpers de presentación
        $invoiceNo = $sale->invoice_number ?? ('VTA-' . $sale->id);
        $soldAt    = $sale->sold_at ? Carbon::parse($sale->sold_at)->format('d/m/Y H:i') : 'N/D';

        $money = function ($value) {
            $n = is_null($value) ? 0 : (float) $value;
            return 'C$ ' . number_format($n, 2);
        };

        $status = strtolower((string)($sale->status ?? 'completada'));
        $method = strtolower((string)($sale->payment_method ?? 'efectivo'));

        $statusLabel = match ($status) {
            'completed', 'completada' => 'Completada',
            'pending', 'pendiente'    => 'Pendiente',
            'cancelled', 'cancelada'  => 'Cancelada',
            default                  => ucfirst($status ?: 'Completada'),
        };

        $methodLabel = match ($method) {
            'cash', 'efectivo'        => 'Efectivo',
            'card', 'tarjeta'         => 'Tarjeta',
            'transfer', 'transferencia' => 'Transferencia',
            default                   => ucfirst($method ?: 'Efectivo'),
        };

        $chipClass = function ($type, $value) {
            // estilos simples y seguros (sin libs)
            if ($type === 'status') {
                return match (strtolower($value)) {
                    'completada','completed' => 'chip chip-ok',
                    'pendiente','pending'    => 'chip chip-warn',
                    'cancelada','cancelled'  => 'chip chip-bad',
                    default                  => 'chip',
                };
            }
            return 'chip chip-neutral';
        };
    @endphp

    <style>
        :root {
            --border:#e5e7eb;
            --muted:#6b7280;
            --bg:#f9fafb;
            --card:#ffffff;
            --ink:#111827;
            --accent:#111827;
        }

        * { box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; margin: 24px; color: var(--ink); background: var(--bg); }

        .wrap { max-width: 980px; margin: 0 auto; }

        .top {
            display:flex; justify-content:space-between; gap:16px; align-items:flex-start;
        }

        .brand h1 { margin:0; font-size: 22px; letter-spacing: .2px; }
        .muted { color: var(--muted); font-size: 12px; line-height: 1.45; }

        .card {
            background: var(--card);
            border:1px solid var(--border);
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 1px 2px rgba(0,0,0,.04);
        }

        .card-title { font-weight: 800; font-size: 13px; margin-bottom: 10px; }

        .grid { display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-top: 12px; }

        .meta {
            display:grid; grid-template-columns: 1fr 1fr;
            gap: 8px 12px;
            font-size: 13px;
        }
        .meta b { font-weight: 700; }
        .meta .row { display:flex; gap:6px; align-items:center; }

        table { width:100%; border-collapse:collapse; margin-top: 14px; background: var(--card); border:1px solid var(--border); border-radius: 14px; overflow:hidden; }
        thead th {
            padding: 10px 12px;
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .04em;
            background: #f3f4f6;
            border-bottom: 1px solid var(--border);
            text-align:left;
        }
        tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }
        tbody tr:last-child td { border-bottom: none; }
        .right { text-align:right; }

        .totals {
            margin-top: 12px;
            display:flex;
            justify-content:flex-end;
        }
        .totals .card { width: 360px; }
        .totals table { margin-top: 0; border:none; }
        .totals td { border-bottom:none; padding: 7px 0; font-size: 13px; }
        .totals tr:last-child td {
            padding-top: 10px;
            border-top: 1px solid var(--border);
            font-weight: 900;
            font-size: 14px;
        }

        .chip {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid var(--border);
            font-size: 12px;
            background:#fff;
            color: var(--ink);
            white-space: nowrap;
        }
        .chip-ok   { border-color:#bbf7d0; background:#ecfdf5; }
        .chip-warn { border-color:#fde68a; background:#fffbeb; }
        .chip-bad  { border-color:#fecaca; background:#fef2f2; }
        .chip-neutral { border-color: var(--border); background:#fff; }

        .actions { margin-top: 16px; display:flex; gap:10px; flex-wrap:wrap; }
        .btn {
            border:1px solid var(--border);
            background: var(--accent);
            color:#fff;
            padding:10px 12px;
            border-radius: 12px;
            cursor:pointer;
            text-decoration:none;
            display:inline-block;
            font-size: 13px;
        }
        .btn.secondary { background:#fff; color: var(--accent); }
        .footer { margin-top: 18px; font-size: 12px; color: var(--muted); }

        @media (max-width: 900px) {
            .top { flex-direction: column; }
            .grid { grid-template-columns: 1fr; }
            .totals .card { width: 100%; }
        }

        @media print {
            body { margin: 0; background: #fff; }
            .actions { display:none; }
            .card, table { box-shadow:none; }
            .wrap { max-width: 100%; }
        }
    </style>
</head>
<body>
<div class="wrap">

    <div class="top">
        <div class="card" style="flex: 1;">
            <div class="brand">
                <h1>{{ $pharmacy['name'] ?? 'Farmacia' }}</h1>
                <div class="muted" style="margin-top:6px;">
                    Tel: {{ $pharmacy['phone'] ?? 'N/D' }}<br>
                    Dirección: {{ $pharmacy['address'] ?? 'N/D' }}
                </div>
            </div>
        </div>

        <div class="card" style="min-width: 320px;">
            <div class="card-title">Factura</div>

            <div class="meta">
                <div class="row"><span class="muted"><b>N°:</b></span> <span>{{ $invoiceNo }}</span></div>
                <div class="row"><span class="muted"><b>Fecha:</b></span> <span>{{ $soldAt }}</span></div>

                <div class="row">
                    <span class="muted"><b>Estado:</b></span>
                    <span class="{{ $chipClass('status', $statusLabel) }}">{{ $statusLabel }}</span>
                </div>

                <div class="row">
                    <span class="muted"><b>Método:</b></span>
                    <span class="{{ $chipClass('method', $methodLabel) }}">{{ $methodLabel }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="card">
            <div class="card-title">Cliente</div>
            <div class="muted" style="font-size:13px;">
                <b>Nombre:</b> {{ $sale->customer_name ?? 'Consumidor final' }}<br>
                <b>Teléfono:</b> {{ $sale->customer_phone ?? 'N/D' }}<br>
                <b>Email:</b> {{ $sale->customer_email ?? 'N/D' }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">Vendedor</div>
            <div class="muted" style="font-size:13px;">
                <b>Nombre:</b> {{ $sale->seller_name ?? 'N/D' }}<br>
                <b>Email:</b> {{ $sale->seller_email ?? 'N/D' }}
            </div>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th style="width:46%;">Producto</th>
            <th class="right" style="width:12%;">Cant.</th>
            <th class="right" style="width:21%;">Precio</th>
            <th class="right" style="width:21%;">Total</th>
        </tr>
        </thead>
        <tbody>
        @forelse($items as $it)
            <tr>
                <td>{{ $it->product_name }}</td>
                <td class="right">{{ number_format((float)$it->quantity, 0) }}</td>
                <td class="right">{{ $money($it->unit_price) }}</td>
                <td class="right">{{ $money($it->line_total) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="muted">No hay items en esta venta.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="totals">
        <div class="card">
            <table>
                <tr>
                    <td class="muted">Subtotal</td>
                    <td class="right">{{ $money($sale->subtotal ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="muted">Impuesto</td>
                    <td class="right">{{ $money($sale->tax ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="muted">Descuento</td>
                    <td class="right">- {{ $money($sale->discount ?? 0) }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="right">{{ $money($sale->total ?? 0) }}</td>
                </tr>
            </table>
        </div>
    </div>

   <div class="actions">
    <button class="btn" onclick="window.print()">Imprimir</button>

    <a class="btn" href="{{ route('invoices.pdf', ['sale' => $sale->id]) }}">
        Descargar PDF
    </a>

    <a class="btn secondary" href="javascript:history.back()">Volver</a>
</div>

    <div class="footer">
        Documento generado por el Sistema de Inventario y Facturación — {{ $pharmacy['name'] ?? 'Farmacia' }}.
    </div>

</div>
</body>
</html>
