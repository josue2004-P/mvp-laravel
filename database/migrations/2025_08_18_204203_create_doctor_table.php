<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctores', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100)->nullable();
            $table->string('cedula_profesional', 50)->unique();
            
            // Llave foránea a especialidades
            $table->foreignId('especialidad_id')
                  ->constrained('especialidades')
                  ->onDelete('restrict'); // Evita borrar especialidades en uso
            
            $table->string('email', 255)->unique()->nullable();
            $table->string('telefono', 20)->nullable();
            $table->boolean('is_activo')->default(true);
            
            $table->index('especialidad_id','idx_doctor_especialidad');
            
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctores');
    }
};