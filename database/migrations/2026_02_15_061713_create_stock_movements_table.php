<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained('products');

    $table->string('type'); // entrada, salida, ajuste
    $table->integer('quantity'); // + o -
    $table->string('reason')->nullable(); // venta, compra, ajuste, etc.

    // Relación opcional con venta/compra
    $table->foreignId('sale_id')->nullable()->constrained('sales')->nullOnDelete();
    $table->foreignId('purchase_id')->nullable()->constrained('purchases')->nullOnDelete();

    $table->foreignId('user_id')->constrained('users'); // quién hizo el movimiento
    $table->dateTime('moved_at');

    $table->timestamps();

    $table->index(['moved_at']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
