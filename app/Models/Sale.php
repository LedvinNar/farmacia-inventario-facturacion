<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $table = 'sales';

    /**
     * Campos típicos en ventas.
     * Si tu tabla tiene otros nombres, lo ajustamos luego.
     */
    protected $fillable = [
        'customer_id',
        'subtotal',
        'tax',
        'discount',
        'total',
        'paid',
        'change',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid' => 'decimal:2',
        'change' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =========================
    // Relaciones
    // =========================

    /**
     * Una venta pertenece a un cliente.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Una venta tiene muchos items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

    // =========================
    // Helpers PRO
    // =========================

    /**
     * Recalcula totales en base a sus items.
     * (Ideal cuando guardemos items y queramos total correcto.)
     */
    public function recalcTotals(): void
    {
        $subtotal = $this->items()->sum('line_total');

        $tax = (float) ($this->tax ?? 0);
        $discount = (float) ($this->discount ?? 0);

        $this->subtotal = $subtotal;
        $this->total = max(0, $subtotal + $tax - $discount);
    }
}
