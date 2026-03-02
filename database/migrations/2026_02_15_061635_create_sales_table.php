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
        Schema::create('sales', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique(); // consecutivo
    $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
    $table->foreignId('user_id')->constrained('users'); // vendedor que hizo la venta

    $table->dateTime('sold_at');
    $table->decimal('subtotal', 10, 2)->default(0);
    $table->decimal('tax', 10, 2)->default(0);
    $table->decimal('discount', 10, 2)->default(0);
    $table->decimal('total', 10, 2)->default(0);

    $table->string('payment_method')->default('efectivo'); // efectivo, tarjeta, etc.
    $table->string('status')->default('completada'); // completada, anulada

    $table->timestamps();

    $table->index(['sold_at']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
