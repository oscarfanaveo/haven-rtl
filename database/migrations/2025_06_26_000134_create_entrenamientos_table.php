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
        Schema::create('entrenamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('equipamiento')->nullable(); // Campo de texto largo para equipamiento
            $table->string('musculo', 100)->nullable(); // Músculo principal trabajado
            $table->text('descripcion')->nullable();
            $table->text('imagen')->nullable(); // Podría ser una URL o una ruta de archivo
            $table->text('enlace')->nullable(); // Podría ser un enlace a un video
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrenamientos');
    }
};
