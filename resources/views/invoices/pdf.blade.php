<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $sale->invoice_number ?? ('VTA-' . $sale->id) }}</title>

    @php
        use Carbon\Carbon;

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
            default                   => ucfirst($status ?: 'Completada'),
        };

        $methodLabel = match ($method) {
            'cash', 'efectivo'          => 'Efectivo',
            'card', 'tarjeta'           => 'Tarjeta',
            'transfer', 'transferencia' => 'Transferencia',
            default                     => ucfirst($method ?: 'Efectivo'),
        };
    @endphp

    <style>
        /* ✅ DOMPDF PRO: márgenes A4 reales */
        @page { size: A4; margin: 16mm 14mm; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .muted { color:#6b7280; font-size: 11px; }
        .h1 { font-size: 18px; font-weight: 800; margin: 0; }
        .box {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 12px;
        }

        /* Layout fijo para PDF */
        .row { width: 100%; }
        .col-left { width: 58%; display: inline-block; vertical-align: top; }
        .col-right { width: 40%; display: inline-block; vertical-align: top; margin-left: 2%; }

        .title { font-weight: 800; font-size: 12px; margin-bottom: 6px; }

        .chip {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            ont-size: 11px;
            line-height: 1;
            vertical-align: middle;
            margin-top: 2px;
          }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead th {
            background: #f3f4f6;
            color: #6b7280;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11.5px;
        }
        .right { text-align: right; }

        .grid { margin-top: 10px; }
        .grid .col { width: 49%; display: inline-block; vertical-align: top; }
        .grid .col + .col { margin-left: 2%; }

        .totals {
            margin-top: 10px;
            width: 42%;
            margin-left: 58%;
        }
        .totals table { margin-top: 0; }
        .totals td { border-bottom: none; padding: 6px 0; font-size: 11.5px; }
        .totals tr:last-child td {
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
            font-weight: 900;
            font-size: 12.5px;
        }

        .footer {
            margin-top: 14px;
            font-size: 10.5px;
            color: #6b7280;
        }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <div class="row">
        <div class="col-left box">
            <div class="h1">{{ $pharmacy['name'] ?? 'Farmacia' }}</div>
            <div class="muted" style="margin-top:4px;">
                Tel: {{ $pharmacy['phone'] ?? 'N/D' }}<br>
                Dirección: {{ $pharmacy['address'] ?? 'N/D' }}
            </div>
        </div>

        <div class="col-right box">
            <div class="title">Factura</div>
            <div style="font-size: 11.5px;">
                <b>N°:</b> {{ $invoiceNo }}<br>
                <b>Fecha:</b> {{ $soldAt }}<br>
                <b>Estado:</b> <span class="chip">{{ $statusLabel }}</span><br>
                <b>Método:</b> <span class="chip">{{ $methodLabel }}</span>
            </div>
        </div>
    </div>

    <!-- Cliente / Vendedor -->
    <div class="grid">
        <div class="col box">
            <div class="title">Cliente</div>
            <div style="font-size: 11.5px;">
                <b>Nombre:</b> {{ $sale->customer_name ?? 'Consumidor final' }}<br>
                <b>Teléfono:</b> {{ $sale->customer_phone ?? 'N/D' }}<br>
                <b>Email:</b> {{ $sale->customer_email ?? 'N/D' }}
            </div>
        </div>

        <div class="col box">
            <div class="title">Vendedor</div>
            <div style="font-size: 11.5px;">
                <b>Nombre:</b> {{ $sale->seller_name ?? 'N/D' }}<br>
                <b>Email:</b> {{ $sale->seller_email ?? 'N/D' }}
            </div>
        </div>
    </div>

    <!-- Detalle -->
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
        @foreach($items as $it)
            <tr>
                <td>{{ $it->product_name }}</td>
                <td class="right">{{ number_format((float)$it->quantity, 0) }}</td>
                <td class="right">{{ $money($it->unit_price) }}</td>
                <td class="right">{{ $money($it->line_total) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Totales -->
    <div class="totals">
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

    <div class="footer">
        Documento generado por el Sistema de Inventario y Facturación — {{ $pharmacy['name'] ?? 'Farmacia' }}.
    </div>

</body>
</html>
