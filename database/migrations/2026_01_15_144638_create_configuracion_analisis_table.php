<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminamos si existe para limpiar errores anteriores
        Schema::dropIfExists('configuracion_analisis');

        Schema::create('configuracion_analisis', function (Blueprint $table) {
            $table->id(); // int [pk, increment]
            
            // Relación con el estatus (debe ser el mismo tipo que estatus_analises.id)
            $table->unsignedSmallInteger('inicialEstatusId');
            
            // Auditoría (IDs de usuario)
            $table->unsignedInteger('usuarioIdCreacion');
            $table->unsignedInteger('usuarioIdActualizacion');
            
            // Fechas
            $table->datetime('fechaCreacion')->useCurrent();
            $table->datetime('fechaActualizacion')->useCurrent()->useCurrentOnUpdate();

            // Llave foránea para el estatus inicial
            $table->foreign('inicialEstatusId')
                  ->references('id')
                  ->on('estatus_analises')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_analisis');
    }
};