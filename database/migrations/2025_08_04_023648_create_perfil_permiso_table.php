<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfil_permiso', function (Blueprint $table) {

            // Relaciones
            $table->foreignId('perfil_id')->constrained('perfiles')->onDelete('cascade');
            $table->foreignId('permiso_id')->constrained('permisos')->onDelete('cascade');

            // Atributos de la matriz de permisos
            $table->boolean('is_leer')->default(false);
            $table->boolean('is_crear')->default(false);
            $table->boolean('is_actualizar')->default(false);
            $table->boolean('is_eliminar')->default(false);
            
            $table->timestamps();

            $table->primary(['perfil_id', 'permiso_id'],'pk_perfil_permiso_matriz');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfil_permiso');
    }
};

