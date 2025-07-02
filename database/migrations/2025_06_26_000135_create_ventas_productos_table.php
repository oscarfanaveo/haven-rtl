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
        Schema::create('ventas_productos', function (Blueprint $table) {
            // Clave foránea hacia la tabla 'ventas'. Si se borra una venta, se borra el registro aquí.
            $table->foreignId('id_venta')->constrained('ventas')->onDelete('cascade');
            // Clave foránea hacia la tabla 'productos'.
            $table->foreignId('id_producto')->constrained('productos');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            // Define una clave primaria compuesta por id_venta y id_producto.
            $table->primary(['id_venta', 'id_producto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_productos');
    }
};
