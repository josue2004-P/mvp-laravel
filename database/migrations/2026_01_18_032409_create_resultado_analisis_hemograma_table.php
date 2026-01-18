<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultado_analisis_hemograma', function (Blueprint $table) {
            $table->id();

            $table->foreignId('analisis_id')
                  ->constrained('analisis')
                  ->onDelete('cascade');

            $table->foreignId('hemograma_completo_id')
                  ->constrained('hemograma_completo')
                  ->onDelete('restrict');

            $table->string('resultado', 100)->nullable();

            $table->foreignId('usuario_creacion_id')->constrained('users');
            $table->foreignId('usuario_actualizacion_id')->constrained('users');

            $table->timestamps();

            $table->unique(['analisis_id', 'hemograma_completo_id'], 'idx_resultado_hc_unique');
            
            $table->index('analisis_id', 'idx_resultado_analisis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultado_analisis_hemograma');
    }
};