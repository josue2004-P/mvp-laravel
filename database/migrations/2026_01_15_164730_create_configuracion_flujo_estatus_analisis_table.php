<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('configuracion_flujo_estatus_analisis', function (Blueprint $table) {
            $table->foreignId('configuracion_analisis_id')
                ->constrained('configuracion_analisis', indexName: 'fk_flujo_conf_id')
                ->onDelete('cascade');

            $table->foreignId('estatus_id')
                ->constrained('estatus_analisis', indexName: 'fk_flujo_est_orig')
                ->onDelete('cascade');

            // CORRECCIÓN: Un solo método constrained con el nombre manual
            $table->foreignId('estatus_siguiente_id')
                ->constrained('estatus_analisis', indexName: 'fk_flujo_est_sig')
                ->onDelete('cascade');

            $table->foreignId('usuario_creacion_id')
                ->constrained('users', indexName: 'fk_flujo_u_crea')
                ->onDelete('restrict');

            $table->foreignId('usuario_actualizacion_id')
                ->constrained('users', indexName: 'fk_flujo_u_act')
                ->onDelete('restrict');

            $table->timestamps();

            // No olvides la llave primaria compuesta que definiste en tu diagrama
            $table->primary(
                ['configuracion_analisis_id', 'estatus_id', 'estatus_siguiente_id'], 
                'pk_conf_flujo_estatus'
            );
        });
    }

    public function down(): void {
        Schema::dropIfExists('configuracion_flujo_estatus_analisis');
    }
};