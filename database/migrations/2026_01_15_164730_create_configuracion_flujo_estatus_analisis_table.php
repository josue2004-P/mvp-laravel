<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('configuracion_flujo_estatus_analisis', function (Blueprint $table) {
            $table->foreignId('configuracion_analisis_id')->constrained('configuracion_analisis')->onDelete('cascade');
            $table->foreignId('estatus_id')->constrained('estatus_analisis')->onDelete('cascade');
            $table->foreignId('estatus_siguiente_id')->constrained('estatus_analisis')->onDelete('cascade');
            
            $table->foreignId('usuario_creacion_id')->constrained('users');
            $table->foreignId('usuario_actualizacion_id')->constrained('users');
            $table->timestamps();

            $table->primary(['configuracion_analisis_id', 'estatus_id', 'estatus_siguiente_id'], 'pk_conf_flujo_estatus');
            
            $table->index('estatus_id', 'idx_flujo_origen');
        });
    }

    public function down(): void {
        Schema::dropIfExists('configuracion_flujo_estatus_analisis');
    }
};