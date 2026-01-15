<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_perfil_estatus_analisis', function (Blueprint $table) {
            // Debe ser unsignedBigInteger para ser compatible con $table->id() de la tabla padre
            $table->unsignedBigInteger('configuracionAnalisisId');
            
            // Perfiles usualmente usan id() (BigInt) o Increments (Int). Ajusta según tu tabla 'perfils'
            $table->unsignedBigInteger('perfilId'); 
            
            // Coincide con el unsignedSmallInteger de 'estatus_analises'
            $table->unsignedSmallInteger('estatusId');
            
            $table->boolean('modificar')->default(0);
            $table->boolean('automatico')->default(0);
            $table->unsignedBigInteger('usuarioIdCreacion');
            $table->datetime('fechaCreacion')->useCurrent();

            // --- LLAVES FORÁNEAS CON NOMBRES CORTOS ---
            
            $table->foreign('configuracionAnalisisId', 'fk_conf_anl_id')
                ->references('id')->on('configuracion_analisis')
                ->onDelete('cascade');

            $table->foreign('perfilId', 'fk_perf_anl_id')
                ->references('id')->on('perfils')
                ->onDelete('cascade');

            $table->foreign('estatusId', 'fk_est_anl_id')
                ->references('id')->on('estatus_analises')
                ->onDelete('cascade');

            // Índice único para evitar duplicados de configuración por perfil/estatus
            $table->unique(['configuracionAnalisisId', 'perfilId', 'estatusId'], 'uk_conf_perf_est');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_perfil_estatus_analisis');
    }
};