<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('configuracion_perfil_estatus_analisis', function (Blueprint $table) {
            $table->foreignId('configuracion_analisis_id')
                ->constrained('configuracion_analisis', indexName: 'fk_conf_perfil_analisis_id')
                ->onDelete('cascade');
            $table->foreignId('perfil_id')->constrained('perfiles')->onDelete('cascade');
            $table->foreignId('estatus_id')->constrained('estatus_analisis')->onDelete('cascade');
            
            $table->boolean('modificar')->default(false);
            $table->boolean('automatico')->default(false);
            
            $table->foreignId('usuario_creacion_id')
                ->constrained('users', indexName: 'fk_conf_perfil_u_crea')
                ->onDelete('restrict');

            $table->foreignId('usuario_actualizacion_id')
                ->constrained('users', indexName: 'fk_conf_perfil_u_act')
                ->onDelete('restrict');
            $table->timestamps();

            $table->primary(['configuracion_analisis_id', 'perfil_id', 'estatus_id'], 'pk_conf_perfil_estatus');
            
            $table->index(['perfil_id', 'estatus_id'], 'idx_perfil_permiso_estatus');
        });
    }

    public function down(): void {
        Schema::dropIfExists('configuracion_perfil_estatus_analisis');
    }
};