<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre')->unique();
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('email')->nullable();
            $table->integer('edad');
            $table->date('fecha_nacimiento')->nullable()->comment('Formato: YYYY-MM-DD');
            $table->string('sexo', 10);
            
            // Dirección
            $table->string('calle')->nullable();
            $table->string('no_exterior', 20)->nullable();
            $table->string('no_interior', 20)->nullable();
            $table->string('colonia')->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('estado', 100)->nullable();
            
            $table->text('referencia')->nullable();
            $table->boolean('is_activo')->default(true);
            
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};