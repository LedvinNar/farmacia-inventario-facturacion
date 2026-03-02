<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    // Si tu tabla se llama "customers", esto es opcional, pero lo dejamos PRO/clarito:
    protected $table = 'customers';

    /**
     * Campos permitidos para asignación masiva (create/update).
     * Ajustá estos nombres si tu tabla usa otros.
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
    ];

    /**
     * Casts (por si querés ordenar/filtrar por fechas)
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =========================
    // Relaciones
    // =========================

    /**
     * Un cliente tiene muchas ventas.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }
}
