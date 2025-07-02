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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->string('nombre', 100);
            $table->string('correo', 100)->unique();
            $table->string('contraseña'); // Laravel maneja el hashing
            $table->enum('rol', ['admin', 'empleado']); // Usamos enum para el check
            $table->timestamps(); // incluye creado_en y actualizado_en
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
