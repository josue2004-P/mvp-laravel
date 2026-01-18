<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('perfil_user', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('perfil_id')->constrained('perfiles')->onDelete('cascade');

            $table->timestamps();

            // Definición de la Clave Primaria Compuesta
            $table->primary(['user_id', 'permiso_id'],'pk_usuario_permiso_matriz');

        });
    }

    public function down()
    {
        Schema::dropIfExists('perfil_user');
    }
};