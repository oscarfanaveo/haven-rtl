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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            // foreignId para la relación con la tabla 'clientes'. Puede ser nulo.
            $table->foreignId('id_cliente')->nullable()->constrained('clientes');
            $table->timestamp('fecha')->useCurrent(); // Fecha de la venta, por defecto la actual
            $table->decimal('total', 10, 2);
            // enum para el estado de la venta, con valores predefinidos.
            $table->enum('estado', ['pagado', 'pendiente', 'cancelado']);
            // foreignId para la relación con la tabla 'usuarios'.
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
