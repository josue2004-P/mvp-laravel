<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfil_permiso', function (Blueprint $table) {

            $table->unsignedBigInteger('perfil_id');
            $table->unsignedBigInteger('permiso_id');

            // PERMISOS CRUD
            $table->boolean('leer')->default(false);
            $table->boolean('crear')->default(false);
            $table->boolean('actualizar')->default(false);
            $table->boolean('eliminar')->default(false);

            $table->timestamps();

            $table->foreign('perfil_id')
                ->references('id')
                ->on('perfils')
                ->onDelete('cascade');

            $table->foreign('permiso_id')
                ->references('id')
                ->on('permisos')
                ->onDelete('cascade');

            $table->primary(['perfil_id', 'permiso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfil_permiso');
    }
};

