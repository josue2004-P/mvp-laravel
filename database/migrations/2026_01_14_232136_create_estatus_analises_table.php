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
        Schema::create('estatus_analises', function (Blueprint $table) {
            $table->id(); 
            
            $table->string('nombre');
            $table->string('descripcion');

            $table->string('color_texto', 10)->nullable();
            $table->string('color_fondo', 10)->nullable();
            
            $table->boolean('analisis_abierto')->default(0);
            $table->boolean('analisis_cerrado')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estatus_analises');
    }
};
