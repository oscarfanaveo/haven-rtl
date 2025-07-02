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
        Schema::create('actividad_clientes', function (Blueprint $table) {
            $table->id();
            // El id_cliente debe ser único para que cada cliente tenga un solo registro de actividad.
            $table->foreignId('id_cliente')->unique()->constrained('clientes');
            $table->integer('entradas_usadas')->default(0);
            $table->integer('cambios_plan')->default(0);
            $table->integer('renovaciones')->default(0);
            $table->timestamp('ultimo_ingreso')->nullable(); // Fecha del último ingreso
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_clientes');
    }
};
