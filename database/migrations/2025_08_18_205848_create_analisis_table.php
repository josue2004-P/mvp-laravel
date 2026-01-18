<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analisis', function (Blueprint $table) {
            $table->id();

            // Llaves Foráneas
            $table->foreignId('estatus_id')->constrained('estatus_analisis');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('doctor_id')->constrained('doctores');
            $table->foreignId('tipo_analisis_id')->constrained('tipo_analisis');
            $table->foreignId('tipo_metodo_id')->constrained('tipo_metodo');
            $table->foreignId('tipo_muestra_id')->constrained('tipo_muestra');
            $table->foreignId('usuario_creacion_id')->constrained('users');

            $table->string('nota', 255)->nullable();
            $table->timestamps();

            $table->index('tipo_analisis_id', 'idx_analisis_tipo');
            $table->index('tipo_metodo_id', 'idx_analisis_metodo');
            $table->index('tipo_muestra_id', 'idx_analisis_muestra');

            $table->index('estatus_id', 'idx_analisis_estatus');
            $table->index('cliente_id', 'idx_analisis_cliente');
            $table->index('doctor_id', 'idx_analisis_doctor');
            $table->index('created_at', 'idx_analisis_fecha');

            $table->index(['cliente_id', 'created_at'], 'idx_cliente_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analisis');
    }
};