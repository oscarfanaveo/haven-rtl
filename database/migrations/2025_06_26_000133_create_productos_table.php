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
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Equivalente a SERIAL PRIMARY KEY
            $table->string('nombre', 100);
            $table->string('categoria', 100)->nullable(); // La categoría puede ser opcional
            $table->decimal('precio', 10, 2); // Precio con 10 dígitos en total y 2 decimales
            $table->integer('stock')->default(0); // Stock del producto, por defecto 0
            $table->boolean('estado')->default(true); // Estado del producto (activo/inactivo)
            $table->timestamps(); // Crea las columnas created_at y updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
