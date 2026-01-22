<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hemograma_completo_tipo_analisis', function (Blueprint $table) {
            $table->id();

            // Relación con hemograma_completo
            $table->foreignId('hemograma_completo_id')
                  ->constrained('hemograma_completo')
                  ->onDelete('cascade');

            // Relación con tipo_analisis
            $table->foreignId('tipo_analisis_id')
                  ->constrained('tipo_analisis')
                  ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['hemograma_completo_id', 'tipo_analisis_id'], 'hc_ta_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hemograma_completo_tipo_analisis');
    }
};
