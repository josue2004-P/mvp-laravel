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
        Schema::create('hemograma_completo', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre');

            // RELACIONES
            $table->foreignId('categoria_hemograma_completo_id')->constrained('categoria_hemograma_completo')->onDelete('cascade');
            $table->foreignId('unidad_id')->constrained('unidades')->onDelete('restrict');
            
            $table->string('referencia')->nullable(); 
            $table->timestamps();

            $table->index(['categoria_hemograma_completo_id', 'unidad_id'],'idx_hemograma_cat_unid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hemograma_completo');
    }
};
