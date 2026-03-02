<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'Sistema') }}</title>

    {{-- Tipografía limpia (sin depender de Tailwind/Vite) --}}
    <style>
        :root{
            --bg:#0b1220;
            --panel:#0f1a2f;
            --card:#0f172a;
            --card2:#111c33;
            --line:rgba(255,255,255,.08);
            --muted:rgba(255,255,255,.65);
            --text:#e5e7eb;
            --brand:#22c55e;
            --brand2:#16a34a;
            --danger:#ef4444;
            --warn:#f59e0b;
            --info:#38bdf8;
            --shadow:0 10px 25px rgba(0,0,0,.25);
            --radius:16px;
        }

        *{ box-sizing:border-box; }
        html,body{ height:100%; }
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
            background: radial-gradient(1200px 800px at 10% 10%, rgba(34,197,94,.18), transparent 55%),
                        radial-gradient(900px 700px at 90% 20%, rgba(56,189,248,.12), transparent 55%),
                        radial-gradient(1100px 900px at 40% 110%, rgba(245,158,11,.08), transparent 60%),
                        var(--bg);
            color: var(--text);
        }

        a{ color:inherit; text-decoration:none; }
        .container{ max-width: 1180px; margin:0 auto; padding: 22px; }

        /* Topbar */
        .topbar{
            position: sticky; top:0; z-index:50;
            background: rgba(11,18,32,.65);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .topbar-inner{
            max-width: 1180px; margin:0 auto; padding: 14px 22px;
            display:flex; align-items:center; justify-content:space-between; gap:12px;
        }
        .brand{
            display:flex; align-items:center; gap:10px;
            font-weight: 900;
            letter-spacing: .3px;
        }
        .logo{
            width: 40px; height: 40px; border-radius: 14px;
            background: linear-gradient(135deg, rgba(34,197,94,.95), rgba(56,189,248,.35));
            box-shadow: 0 10px 20px rgba(34,197,94,.15);
            display:grid; place-items:center;
            border: 1px solid rgba(255,255,255,.10);
        }
        .logo span{ font-size: 16px; }
        .brand small{
            display:block; font-weight:600; color: var(--muted); letter-spacing:0;
            margin-top:2px;
        }

        /* Nav */
        .nav{
            display:flex; flex-wrap:wrap; gap:8px; align-items:center; justify-content:flex-end;
        }
        .nav a{
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid transparent;
            color: rgba(255,255,255,.78);
            background: rgba(255,255,255,.02);
        }
        .nav a:hover{
            border-color: rgba(255,255,255,.10);
            background: rgba(255,255,255,.05);
            color: #fff;
        }
        .nav a.active{
            border-color: rgba(34,197,94,.30);
            background: rgba(34,197,94,.08);
            color: #fff;
        }

        /* Page header */
        .page-head{
            display:flex; gap:12px; align-items:flex-end; justify-content:space-between; flex-wrap:wrap;
            margin-top: 18px;
        }
        .page-title{
            font-size: 20px; font-weight: 900; margin:0;
        }
        .page-sub{
            margin:6px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height:1.4;
        }

        /* Cards */
        .grid{ display:grid; gap:12px; }
        .card{
            background: linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,.015));
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .card .card-body{ padding: 14px; }
        .card .card-head{
            padding: 14px;
            border-bottom: 1px solid var(--line);
            display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
        }
        .badge{
            display:inline-block;
            border: 1px solid rgba(255,255,255,.10);
            background: rgba(255,255,255,.04);
            color: rgba(255,255,255,.85);
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
        }

        /* Buttons */
        .btn{
            display:inline-flex; align-items:center; gap:8px;
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,.10);
            background: rgba(255,255,255,.05);
            color: #fff;
            cursor:pointer;
            font-weight: 700;
            font-size: 13px;
            line-height:1;
            white-space: nowrap;
        }
        .btn:hover{ background: rgba(255,255,255,.08); }
        .btn.primary{
            border-color: rgba(34,197,94,.35);
            background: linear-gradient(135deg, rgba(34,197,94,.95), rgba(22,163,74,.55));
        }
        .btn.primary:hover{
            background: linear-gradient(135deg, rgba(34,197,94,.98), rgba(22,163,74,.65));
        }
        .btn.danger{
            border-color: rgba(239,68,68,.35);
            background: linear-gradient(135deg, rgba(239,68,68,.92), rgba(239,68,68,.45));
        }
        .btn.secondary{
            background: rgba(255,255,255,.03);
        }

        /* Forms */
        .row{ display:flex; gap:10px; flex-wrap:wrap; }
        .field{ width: 260px; max-width:100%; }
        label{ display:block; font-size: 12px; color: var(--muted); margin: 0 0 6px; }
        input, select, textarea{
            width:100%;
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,.10);
            background: rgba(15, 23, 42, .65);
            color: #fff;
            outline: none;
        }
        textarea{ min-height: 90px; resize: vertical; }
        input:focus, select:focus, textarea:focus{
            border-color: rgba(34,197,94,.35);
            box-shadow: 0 0 0 4px rgba(34,197,94,.12);
        }
        .help{ font-size: 12px; color: var(--muted); margin-top:6px; }

        /* Tables */
        table{ width:100%; border-collapse: collapse; overflow:hidden; border-radius: 14px; }
        thead th{
            text-align:left;
            font-size: 12px;
            color: rgba(255,255,255,.72);
            padding: 12px;
            border-bottom: 1px solid var(--line);
            background: rgba(255,255,255,.03);
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        tbody td{
            padding: 12px;
            border-bottom: 1px solid var(--line);
            color: rgba(255,255,255,.90);
        }
        tbody tr:hover td{ background: rgba(255,255,255,.02); }
        .right{ text-align:right; }

        /* Alerts */
        .alert{
            margin-top: 14px;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: rgba(255,255,255,.04);
        }
        .alert.ok{ border-color: rgba(34,197,94,.30); background: rgba(34,197,94,.08); }
        .alert.bad{ border-color: rgba(239,68,68,.30); background: rgba(239,68,68,.08); }
        .alert.warn{ border-color: rgba(245,158,11,.30); background: rgba(245,158,11,.08); }
        .alert b{ font-weight: 900; }

        /* Footer */
        .footer{
            margin-top: 16px;
            color: var(--muted);
            font-size: 12px;
            padding: 10px 2px;
        }

        @media print{
            .topbar{ position: static; backdrop-filter:none; }
            .nav, .no-print{ display:none !important; }
            body{ background:#fff; color:#111; }
            .card{ box-shadow:none; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="topbar">
        <div class="topbar-inner">
            <div class="brand">
                <div class="logo"><span>💊</span></div>
                <div>
                    {{ config('app.name', 'Farmacia Silva') }}
                    <small>Sistema de Inventario y Facturación</small>
                </div>
            </div>

            <nav class="nav">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Inicio</a>
                <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>

                <a href="{{ route('core.customers.index') }}" class="{{ request()->is('core/customers*') ? 'active' : '' }}">Clientes</a>
                <a href="{{ route('core.products.index') }}" class="{{ request()->is('core/products*') ? 'active' : '' }}">Productos</a>
                <a href="{{ route('sales.index') }}" class="{{ request()->is('sales*') ? 'active' : '' }}">Ventas</a>

                <a href="{{ route('reports.sales') }}" class="{{ request()->is('reports/sales*') ? 'active' : '' }}">Reporte Ventas</a>
                <a href="{{ route('reports.purchases') }}" class="{{ request()->is('reports/purchases*') ? 'active' : '' }}">Reporte Compras</a>

                <a href="{{ route('backup.index') }}" class="{{ request()->is('backup*') ? 'active' : '' }}">Backup</a>
            </nav>
        </div>
    </div>

    <main class="container">
        <div class="page-head">
            <div>
                <h1 class="page-title">{{ $pageTitle ?? ($title ?? 'Panel') }}</h1>
                @if(!empty($pageSubtitle))
                    <p class="page-sub">{{ $pageSubtitle }}</p>
                @endif
            </div>

            <div class="no-print">
                @yield('actions')
            </div>
        </div>

        {{-- Mensajes --}}
        @if(session('success'))
            <div class="alert ok"><b>✅ Éxito:</b> {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert bad"><b>⚠️ Error:</b> {!! nl2br(e(session('error'))) !!}</div>
        @endif

        @if($errors->any())
            <div class="alert warn">
                <b>⚠️ Validación:</b>
                <ul style="margin:8px 0 0 18px;">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="margin-top:14px;">
            @yield('content')
        </div>

        <div class="footer">
            © {{ date('Y') }} — {{ config('app.name', 'Farmacia Silva') }} | Módulo PRO
        </div>
    </main>

    @stack('scripts')
</body>
</html>
