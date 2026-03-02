<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas ({{ $from }} a {{ $to }})</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root{
            --border:#e5e7eb;
            --muted:#6b7280;
            --bg:#f9fafb;
            --card:#ffffff;
            --ink:#111827;
            --accent:#111827;
        }
        *{ box-sizing:border-box; }
        body{ font-family: Arial, Helvetica, sans-serif; margin:24px; color:var(--ink); background:var(--bg); }
        .wrap{ max-width: 1100px; margin:0 auto; }

        .top{ display:flex; justify-content:space-between; gap:16px; align-items:flex-start; flex-wrap:wrap; }
        .card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:14px;
            padding:14px;
            box-shadow:0 1px 2px rgba(0,0,0,.04);
        }
        .brand h1{ margin:0; font-size:22px; letter-spacing:.2px; }
        .muted{ color:var(--muted); font-size:12px; line-height:1.45; }
        .title{ font-weight:800; font-size:13px; margin-bottom:10px; }

        .kpis{ display:grid; grid-template-columns: repeat(4, 1fr); gap:12px; margin-top:12px; }
        .kpi .label{ font-size:12px; color:var(--muted); }
        .kpi .value{ font-size:18px; font-weight:900; margin-top:6px; }

        .actions{ margin-top:14px; }
        .filters{ display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap; }
        label{ font-size:12px; color:var(--muted); display:block; margin-bottom:4px; }
        input{
            padding:10px;
            border:1px solid var(--border);
            border-radius:12px;
            background:#fff;
            min-width: 170px;
        }

        .btn{
            border:1px solid var(--border);
            background:var(--accent);
            color:#fff;
            padding:10px 12px;
            border-radius:12px;
            cursor:pointer;
            text-decoration:none;
            display:inline-block;
            font-size:13px;
            line-height:1;
            white-space:nowrap;
        }
        .btn.secondary{ background:#fff; color:var(--accent); }
        .btn.small{ padding:8px 10px; border-radius:10px; font-size:12px; }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:14px;
            background:var(--card);
            border:1px solid var(--border);
            border-radius:14px;
            overflow:hidden;
        }
        thead th{
            padding:10px 12px;
            font-size:12px;
            color:var(--muted);
            text-transform:uppercase;
            letter-spacing:.04em;
            background:#f3f4f6;
            border-bottom:1px solid var(--border);
            text-align:left;
        }
        tbody td{
            padding:10px 12px;
            border-bottom:1px solid var(--border);
            font-size:13px;
        }
        tbody tr:last-child td{ border-bottom:none; }
        .right{ text-align:right; }

        .badge{
            display:inline-block;
            padding:3px 10px;
            border-radius:999px;
            border:1px solid var(--border);
            font-size:12px;
            background:#fff;
            color:var(--ink);
        }

        .footer{ margin-top:14px; font-size:12px; color:var(--muted); }

        @media (max-width: 980px){
            .kpis{ grid-template-columns: 1fr 1fr; }
            input{ min-width: 140px; }
        }

        @media print{
            body{ margin:0; background:#fff; }
            .actions{ display:none; }
            .card, table{ box-shadow:none; }
            .wrap{ max-width:100%; }
        }
    </style>
</head>
<body>
<div class="wrap">

    <div class="top">
        <div class="card" style="flex: 1; min-width: 320px;">
            <div class="brand">
                <h1>Farmacia {{ $pharmacy['name'] ?? 'Silva' }}</h1>
                <div class="muted" style="margin-top:6px;">
                    Tel: {{ $pharmacy['phone'] ?? 'N/D' }}<br>
                    Dirección: {{ $pharmacy['address'] ?? 'N/D' }}
                </div>
            </div>
        </div>

        <div class="card" style="min-width: 320px;">
            <div class="title">Reporte de Ventas</div>
            <div class="muted">
                <b>Rango:</b> {{ $from }} a {{ $to }}<br>
                <b>Registros:</b> {{ $totals['count'] ?? 0 }}<br>
                <b>Total vendido:</b> C$ {{ number_format((float)($totals['total'] ?? 0), 2) }}
            </div>
        </div>
    </div>

    <div class="kpis">
        <div class="card kpi">
            <div class="label">Subtotal</div>
            <div class="value">C$ {{ number_format((float)($totals['subtotal'] ?? 0), 2) }}</div>
        </div>
        <div class="card kpi">
            <div class="label">Impuesto</div>
            <div class="value">C$ {{ number_format((float)($totals['tax'] ?? 0), 2) }}</div>
        </div>
        <div class="card kpi">
            <div class="label">Descuento</div>
            <div class="value">C$ {{ number_format((float)($totals['discount'] ?? 0), 2) }}</div>
        </div>
        <div class="card kpi">
            <div class="label">Total</div>
            <div class="value">C$ {{ number_format((float)($totals['total'] ?? 0), 2) }}</div>
        </div>
    </div>

    <div class="actions">
        <form class="filters" method="GET" action="{{ route('reports.sales') }}">
            <div>
                <label>Desde</label>
                <input type="date" name="from" value="{{ $from }}">
            </div>
            <div>
                <label>Hasta</label>
                <input type="date" name="to" value="{{ $to }}">
            </div>

            <button class="btn" type="submit">Filtrar</button>

            <!-- ✅ Export PRO: exporta con los mismos filtros/querystring -->
            <a class="btn" href="{{ route('reports.sales.export', request()->query()) }}">
                Exportar Excel
            </a>

            <button class="btn secondary" type="button" onclick="window.print()">Imprimir</button>
            <a class="btn secondary" href="javascript:history.back()">Volver</a>

            <span class="badge">Rango activo: {{ $from }} → {{ $to }}</span>
        </form>
    </div>

    <table>
        <thead>
        <tr>
            <th style="width:14%;">Factura</th>
            <th style="width:18%;">Fecha</th>
            <th style="width:22%;">Cliente</th>
            <th style="width:18%;">Vendedor</th>
            <th style="width:12%;">Método</th>
            <th class="right" style="width:10%;">Total</th>
            <th style="width:6%;">Acción</th>
        </tr>
        </thead>
        <tbody>
        @forelse($sales as $s)
            <tr>
                <td>{{ $s->invoice_number ?? ('VTA-' . $s->id) }}</td>
                <td>{{ $s->sold_at ? \Carbon\Carbon::parse($s->sold_at)->format('d/m/Y H:i') : 'N/D' }}</td>
                <td>{{ $s->customer_name ?? 'Consumidor final' }}</td>
                <td>{{ $s->seller_name ?? 'N/D' }}</td>
                <td>{{ ucfirst(strtolower($s->payment_method ?? 'N/D')) }}</td>
                <td class="right">C$ {{ number_format((float)($s->total ?? 0), 2) }}</td>
                <td>
                    <a class="btn secondary small"
                       href="{{ route('invoices.show', ['sale' => $s->id]) }}">
                        Ver
                    </a>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="muted">No hay ventas en ese rango.</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- ✅ Paginación segura (si $sales es paginator) -->
    @if(method_exists($sales, 'links'))
        <div style="margin-top: 12px;">
            {{ $sales->links() }}
        </div>
    @endif

    <div class="footer">
        Documento generado por el Sistema de Inventario y Facturación — Farmacia {{ $pharmacy['name'] ?? 'Silva' }}.
    </div>

</div>
</body>
</html>
