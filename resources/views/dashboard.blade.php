<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Farmacia Silva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root { --border:#e5e7eb; --muted:#6b7280; --bg:#f9fafb; --card:#fff; --dark:#111827; }
        body { font-family: Arial, Helvetica, sans-serif; margin: 24px; color: var(--dark); background: var(--bg); }
        .top { display:flex; justify-content:space-between; gap:20px; align-items:flex-start; }
        .brand h1 { margin:0; font-size: 22px; }
        .muted { color: var(--muted); font-size: 12px; line-height: 1.4; }
        .grid { display:grid; grid-template-columns: repeat(4, 1fr); gap:12px; margin-top: 14px; }
        .card { background: var(--card); border:1px solid var(--border); border-radius:12px; padding:12px; box-shadow: 0 1px 2px rgba(0,0,0,.04); }
        .kpi-title { font-size:12px; color: var(--muted); text-transform:uppercase; letter-spacing:.05em; }
        .kpi-value { font-size:20px; font-weight:800; margin-top:6px; }
        .content { display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-top: 12px; }
        .content2 { display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-top: 12px; }
        .card h2 { margin:0 0 10px 0; font-size:14px; }
        .btns { margin-top: 14px; display:flex; gap:10px; flex-wrap:wrap; }
        .btn { border:1px solid var(--border); background:#111827; color:#fff; padding:10px 12px; border-radius:10px; cursor:pointer; text-decoration:none; display:inline-block; font-size: 13px; }
        .btn.secondary { background:#fff; color:#111827; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:10px; border-bottom:1px solid var(--border); text-align:left; font-size: 13px; }
        th { font-size:12px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
        .right { text-align:right; }
        @media (max-width: 1100px) { .grid { grid-template-columns: repeat(2, 1fr);} .content { grid-template-columns: 1fr; } .content2 { grid-template-columns: 1fr; } }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="top">
    <div class="brand">
        <h1>Farmacia {{ $pharmacy['name'] }} — Dashboard</h1>
        <div class="muted">
            Tel: {{ $pharmacy['phone'] }}<br>
            Dirección: {{ $pharmacy['address'] }}
        </div>

        <div class="btns">
            <a class="btn secondary" href="{{ url('/reports/sales') }}">Reporte Ventas</a>
            <a class="btn secondary" href="{{ url('/reports/purchases') }}">Reporte Compras</a>
        </div>
    </div>

    <div class="card" style="min-width: 280px;">
        <h2>Resumen rápido</h2>
        <div class="muted">Periodo base: últimos 12 meses</div>
        <div style="margin-top:10px" class="muted">
            Ventas: <b>C$ {{ number_format((float)$kpis['sales_total_12m'], 2) }}</b><br>
            Compras: <b>C$ {{ number_format((float)$kpis['purchases_total_12m'], 2) }}</b><br>
            Utilidad aprox: <b>C$ {{ number_format((float)$kpis['gross_12m'], 2) }}</b>
        </div>
    </div>
</div>

<div class="grid">
    <div class="card">
        <div class="kpi-title">Ventas hoy</div>
        <div class="kpi-value">C$ {{ number_format((float)$kpis['sales_today'], 2) }}</div>
        <div class="muted">Registros: {{ (int)$kpis['sales_today_count'] }}</div>
    </div>
    <div class="card">
        <div class="kpi-title">Compras hoy</div>
        <div class="kpi-value">C$ {{ number_format((float)$kpis['purchases_today'], 2) }}</div>
        <div class="muted">Registros: {{ (int)$kpis['purchases_today_count'] }}</div>
    </div>
    <div class="card">
        <div class="kpi-title">Ventas mes</div>
        <div class="kpi-value">C$ {{ number_format((float)$kpis['sales_month'], 2) }}</div>
        <div class="muted">Registros: {{ (int)$kpis['sales_month_count'] }}</div>
    </div>
    <div class="card">
        <div class="kpi-title">Compras mes</div>
        <div class="kpi-value">C$ {{ number_format((float)$kpis['purchases_month'], 2) }}</div>
        <div class="muted">Registros: {{ (int)$kpis['purchases_month_count'] }}</div>
    </div>
</div>

<div class="content">
    <div class="card">
        <h2>📈 Ventas por mes (12 meses)</h2>
        <canvas id="salesChart"></canvas>
    </div>

    <div class="card">
        <h2>📉 Compras por mes (12 meses)</h2>
        <canvas id="purchasesChart"></canvas>
    </div>
</div>

<div class="content2">
    <div class="card">
        <h2>🏆 Top productos vendidos (si existe tabla de items)</h2>
        <canvas id="topProductsChart"></canvas>
        <div class="muted" style="margin-top:8px;">
            Si aparece vacío, es porque tu tabla de detalle no se llama <b>sale_items</b>.
        </div>
    </div>

    <div class="card">
        <h2>💳 Ventas por Método de Pago</h2>
        <canvas id="paymentChart"></canvas>
    </div>

    <!-- ✅ AQUÍ ESTÁ EL NUEVO (SIN QUITAR NADA) -->
    <div class="card">
        <h2>👨‍💼 Ventas por Vendedor</h2>
        <canvas id="sellerChart"></canvas>
    </div>

    <div class="card">
        <h2>⚠️ Stock bajo (si existe tabla products con stock)</h2>

        @if(count($lowStock) === 0)
            <div class="muted">No hay datos (o tu tabla/campo se llama diferente).</div>
        @else
            <table>
                <thead>
                <tr>
                    <th>Producto</th>
                    <th class="right">Stock</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lowStock as $r)
                    <tr>
                        <td>{{ $r->name }}</td>
                        <td class="right">{{ $r->stock }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <div class="muted" style="margin-top:10px;">Umbral: stock ≤ {{ $stockThreshold }}</div>
    </div>
</div>

<script>
    const salesLabels = @json($charts['sales_months']['labels']);
    const salesValues = @json($charts['sales_months']['values']);

    const purchasesLabels = @json($charts['purchases_months']['labels']);
    const purchasesValues = @json($charts['purchases_months']['values']);

    const topLabels = @json($charts['top_products']['labels']);
    const topValues = @json($charts['top_products']['values']);

    const paymentLabels = @json($charts['payment_methods']['labels']);
    const paymentValues = @json($charts['payment_methods']['values']);

    const sellerLabels = @json($charts['sales_by_seller']['labels']);
    const sellerValues = @json($charts['sales_by_seller']['values']);

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: { labels: salesLabels, datasets: [{ label: 'Ventas (C$)', data: salesValues }] },
        options: { responsive: true }
    });

    new Chart(document.getElementById('purchasesChart'), {
        type: 'line',
        data: { labels: purchasesLabels, datasets: [{ label: 'Compras (C$)', data: purchasesValues }] },
        options: { responsive: true }
    });

    new Chart(document.getElementById('topProductsChart'), {
        type: 'bar',
        data: { labels: topLabels, datasets: [{ label: 'Cantidad vendida', data: topValues }] },
        options: { responsive: true }
    });

    new Chart(document.getElementById('paymentChart'), {
        type: 'pie',
        data: {
            labels: paymentLabels,
            datasets: [{
                label: 'Ventas por método',
                data: paymentValues
            }]
        },
        options: { responsive: true }
    });

    new Chart(document.getElementById('sellerChart'), {
        type: 'bar',
        data: {
            labels: sellerLabels,
            datasets: [{
                label: 'Ventas por vendedor (C$)',
                data: sellerValues
            }]
        },
        options: { responsive: true }
    });
</script>

</body>
</html>
