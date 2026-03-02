<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    /**
     * Ajustá si tu tabla usa otros nombres:
     * - name (nombre)
     * - price (precio)
     * - stock (existencias)
     * - brand_id / category_id (si existen en tu BD)
     */
    protected $fillable = [
        'name',
        'price',
        'stock',
        'brand_id',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =========================
    // Relaciones
    // =========================

    /**
     * Un producto puede estar en muchos items de venta.
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class, 'product_id');
    }
}
