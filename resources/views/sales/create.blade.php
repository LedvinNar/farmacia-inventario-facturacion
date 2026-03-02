@extends('layouts.app')

@section('title', 'Nueva venta')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-0">Nueva venta</h3>
        <small class="text-muted">Seleccioná cliente y agregá productos. El total se calcula automáticamente.</small>
    </div>
    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">Volver</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Hay errores:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('sales.store') }}" method="POST" id="saleForm" autocomplete="off">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" @selected(old('customer_id') == $c->id)>
                                {{ $c->name }} {{ $c->phone ? "({$c->phone})" : "" }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Tip: si no aparece, crealo en <b>Core → Customers</b>.</div>
                </div>

                <div class="col-md-6 text-md-end">
                    <label class="form-label d-block">Total</label>
                    <div class="display-6 fw-bold" id="grandTotal">0.00</div>
                    <input type="hidden" name="total" id="totalInput" value="0">
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Productos</h5>
                <button type="button" class="btn btn-outline-primary" id="addRowBtn">
                    + Agregar fila
                </button>
            </div>

            <div class="table-responsive">
                <table class="table align-middle" id="itemsTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 45%;">Producto</th>
                            <th class="text-end" style="width: 15%;">Precio</th>
                            <th class="text-end" style="width: 15%;">Cantidad</th>
                            <th class="text-end" style="width: 15%;">Subtotal</th>
                            <th class="text-end" style="width: 10%;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        {{-- filas por JS --}}
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-outline-secondary" id="resetBtn">
                    Limpiar
                </button>
                <button type="submit" class="btn btn-success" id="submitBtn">
                    Guardar venta
                </button>
            </div>

            <div class="form-text mt-2">
                Nota PRO: si tu controlador usa transacción y descuenta stock, esto valida el flujo real del sistema.
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ✅ IMPORTANTE: SIEMPRE dentro de <script>
    // productsJson debe venir listo desde el controlador (array con id, name, price, stock)
    const PRODUCTS = @json($productsJson ?? []);

    function escapeHtml(str) {
        return String(str)
            .replaceAll('&','&amp;')
            .replaceAll('<','&lt;')
            .replaceAll('>','&gt;')
            .replaceAll('"','&quot;')
            .replaceAll("'","&#039;");
    }

    function productOptionsHtml() {
        let html = `<option value="">— Seleccionar —</option>`;
        for (const p of PRODUCTS) {
            const price = Number(p.price ?? 0);
            const stock = (p.stock ?? null);

            const stockInfo = (stock !== null && stock !== undefined && !Number.isNaN(Number(stock)))
                ? ` | Stock: ${stock}`
                : '';

            html += `
                <option value="${p.id}" data-price="${price}" data-stock="${stock}">
                    ${escapeHtml(p.name)} (C$ ${price.toFixed(2)}${stockInfo})
                </option>
            `;
        }
        return html;
    }

    const itemsBody    = document.getElementById('itemsBody');
    const grandTotalEl = document.getElementById('grandTotal');
    const totalInput   = document.getElementById('totalInput');
    const addRowBtn    = document.getElementById('addRowBtn');
    const resetBtn     = document.getElementById('resetBtn');

    function rowTemplate(index) {
        return `
        <tr class="item-row">
            <td>
                <select class="form-select product-select" name="items[${index}][product_id]" required>
                    ${productOptionsHtml()}
                </select>
                <div class="small text-muted mt-1 stock-hint"></div>
            </td>
            <td class="text-end">
                <input type="number" step="0.01" min="0" class="form-control text-end price-input"
                       name="items[${index}][price]" value="0" required>
            </td>
            <td class="text-end">
                <input type="number" step="1" min="1" class="form-control text-end qty-input"
                       name="items[${index}][qty]" value="1" required>
            </td>
            <td class="text-end fw-semibold subtotal-cell">0.00</td>
            <td class="text-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-row">Quitar</button>
            </td>
        </tr>`;
    }

    function addRow() {
        const index = itemsBody.querySelectorAll('tr.item-row').length;
        itemsBody.insertAdjacentHTML('beforeend', rowTemplate(index));
        bindRow(itemsBody.lastElementChild);
        recalc();
    }

    function bindRow(row) {
        const productSelect = row.querySelector('.product-select');
        const priceInput    = row.querySelector('.price-input');
        const qtyInput      = row.querySelector('.qty-input');
        const stockHint     = row.querySelector('.stock-hint');

        productSelect.addEventListener('change', () => {
            const opt = productSelect.selectedOptions[0];
            const price = parseFloat(opt?.dataset?.price ?? '0') || 0;
            const stock = opt?.dataset?.stock ?? null;

            priceInput.value = price.toFixed(2);

            if (stock !== null && stock !== 'null' && stock !== 'undefined') {
                stockHint.textContent = `Stock disponible: ${stock}`;
            } else {
                stockHint.textContent = '';
            }

            recalc();
        });

        priceInput.addEventListener('input', recalc);
        qtyInput.addEventListener('input', recalc);

        row.querySelector('.remove-row').addEventListener('click', () => {
            row.remove();
            renumberInputs();
            recalc();
        });
    }

    function renumberInputs() {
        const rows = itemsBody.querySelectorAll('tr.item-row');
        rows.forEach((row, idx) => {
            row.querySelector('.product-select').name = `items[${idx}][product_id]`;
            row.querySelector('.price-input').name   = `items[${idx}][price]`;
            row.querySelector('.qty-input').name     = `items[${idx}][qty]`;
        });
    }

    function recalc() {
        let grand = 0;

        const rows = itemsBody.querySelectorAll('tr.item-row');
        rows.forEach(row => {
            const price = parseFloat(row.querySelector('.price-input').value || '0') || 0;
            const qty   = parseFloat(row.querySelector('.qty-input').value || '0') || 0;
            const sub   = price * qty;

            row.querySelector('.subtotal-cell').textContent = sub.toFixed(2);
            grand += sub;
        });

        grandTotalEl.textContent = grand.toFixed(2);
        totalInput.value = grand.toFixed(2);
    }

    addRowBtn.addEventListener('click', addRow);
    resetBtn.addEventListener('click', () => {
        itemsBody.innerHTML = '';
        addRow();
    });

    // Inicial: siempre una fila
    addRow();
</script>
@endpush
