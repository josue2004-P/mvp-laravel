<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_analisis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inicial_estatus_id')
                  ->constrained('estatus_analisis')
                  ->onDelete('restrict');

            $table->foreignId('usuario_creacion_id')
                  ->constrained('users')
                  ->onDelete('restrict');

            $table->foreignId('usuario_actualizacion_id')
                  ->constrained('users')
                  ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_analisis');
    }
};