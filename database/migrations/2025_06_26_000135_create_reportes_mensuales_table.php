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
        Schema::create('reportes_mensuales', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['ventas', 'suscripciones', 'clientes']);
            $table->date('periodo'); // El mes y año del reporte
            $table->jsonb('datos'); // Los datos del reporte en formato JSON
            $table->foreignId('generado_por')->nullable()->constrained('usuarios');
            $table->timestamps(); // created_at servirá como 'fecha_generado'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_mensuales');
    }
};
