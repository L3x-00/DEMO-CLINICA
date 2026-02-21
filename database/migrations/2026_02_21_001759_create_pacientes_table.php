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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni', 8)->unique(); // El DNI siempre tiene 8 dígitos
            $table->string('telefono')->nullable();
            $table->text('historial_medico')->nullable(); // Para las notas del doctor
            $table->timestamps(); // Crea created_at y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
       public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
