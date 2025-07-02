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
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('id_plan')->constrained('planes');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->char('codigo', 6)->unique();
            $table->integer('renovaciones')->default(0);
            $table->integer('cambios_plan')->default(0);
            $table->foreignId('id_usuario')->constrained('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscripciones');
    }
};
