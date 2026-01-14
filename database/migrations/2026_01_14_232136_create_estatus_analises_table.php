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
            $table->smallIncrements('id'); 
            
            $table->string('descripcion', 30);
            $table->string('nombreCorto', 10);
            
            $table->string('colorTexto', 10)->nullable();
            $table->string('colorFondo', 10)->nullable();
            
            $table->boolean('analsisAbierto')->default(0);
            $table->boolean('analisisCerrado')->default(0);

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
