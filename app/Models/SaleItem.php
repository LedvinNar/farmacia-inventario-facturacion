<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $table = 'sale_items';

    /**
     * Campos típicos:
     * - sale_id
     * - product_id
     * - quantity
     * - unit_price
     * - line_total
     */
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'line_total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =========================
    // Relaciones
    // =========================

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // =========================
    // Hooks PRO
    // =========================

    /**
     * Calcula line_total automáticamente antes de guardar.
     */
    protected static function booted(): void
    {
        static::saving(function (SaleItem $item) {
            $qty = (int) ($item->quantity ?? 0);
            $price = (float) ($item->unit_price ?? 0);
            $item->line_total = max(0, $qty * $price);
        });
    }
}
