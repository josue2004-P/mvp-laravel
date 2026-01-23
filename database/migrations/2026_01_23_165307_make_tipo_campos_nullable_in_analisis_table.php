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
        Schema::table('analisis', function (Blueprint $table) {
            // Cambiamos las columnas a nullable
            $table->foreignId('tipo_metodo_id')->nullable()->change();
            $table->foreignId('tipo_muestra_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analisis', function (Blueprint $table) {
            // En caso de rollback, volverían a ser obligatorias
            // Nota: Esto fallará si ya tienes registros con NULL
            $table->foreignId('tipo_metodo_id')->nullable(false)->change();
            $table->foreignId('tipo_muestra_id')->nullable(false)->change();
        });
    }
};