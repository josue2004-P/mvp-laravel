<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_flujo_estatus_analisis', function (Blueprint $table) {
            $table->unsignedBigInteger('configuracionEstatusId');
            $table->unsignedSmallInteger('estatusId');
            $table->unsignedSmallInteger('siguienteEstatusId');

            // CAMBIO AQUÍ: Debe ser unsignedBigInteger para ser compatible con la tabla users
            $table->unsignedBigInteger('usuarioIdCreacion');
            
            $table->datetime('fechaCreacion')->useCurrent();

            // --- LLAVES FORÁNEAS ---

            $table->foreign('configuracionEstatusId', 'fk_flujo_conf_id')
                ->references('id')->on('configuracion_analisis')
                ->onDelete('cascade');

            $table->foreign('estatusId', 'fk_flujo_est_orig')
                ->references('id')->on('estatus_analises')
                ->onDelete('cascade');

            $table->foreign('siguienteEstatusId', 'fk_flujo_est_dest')
                ->references('id')->on('estatus_analises')
                ->onDelete('cascade');

            // Ahora sí será compatible con la tabla users por defecto de Laravel
            $table->foreign('usuarioIdCreacion', 'fk_flujo_usu_crea')
                ->references('id')->on('users')
                ->onDelete('restrict');

            $table->unique(
                ['configuracionEstatusId', 'estatusId', 'siguienteEstatusId'], 
                'uk_flujo_analisis_unico'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_flujo_estatus_analisis');
    }
};