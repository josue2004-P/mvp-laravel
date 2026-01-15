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
    Schema::dropIfExists('configuracion_perfil_estatus_analisis');

    Schema::create('configuracion_perfil_estatus_analisis', function (Blueprint $table) {
        $table->id();
        $table->unsignedTinyInteger('documentoTipo')->comment('1: servicio, 2: requisicion');
        
        // Perfil suele ser BIGINT por defecto
        $table->foreignId('perfilId')->constrained('perfils')->onDelete('cascade');
        
        // CAMBIO CLAVE: Debe ser unsignedSmallInteger para coincidir con smallIncrements
        $table->unsignedSmallInteger('estatusId'); 
        $table->foreign('estatusId')
              ->references('id')
              ->on('estatus_analises')
              ->onDelete('cascade');
        
        $table->boolean('modificar')->default(0);
        $table->boolean('automatico')->default(0);
        
        $table->unsignedInteger('usuarioIdCreacion');
        $table->datetime('fechaCreacion')->useCurrent();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_perfil_estatus_analisis');
    }
};
