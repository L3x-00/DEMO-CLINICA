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
        Schema::create('servicios_realizados', function (Blueprint $table) {
            $table->id();
            // Relación con el paciente (si ya lo tienes en la tabla 'pacientes')
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            
            // Datos del servicio
            $table->string('servicio'); // Ej: Rayos X, Ecografía
            $table->text('observacion')->nullable();
            
            // Finanzas 💰
            $table->decimal('costo', 10, 2); // Hasta 99,999,999.99
            $table->decimal('comision', 10, 2)->default(0); // Monto para la "jaladora"
            $table->string('jaladora')->nullable(); // Nombre de la persona que trajo al paciente
            
            // Seguimiento y Seguridad 🛡️
            $table->foreignId('asistente_id')->constrained('users'); // Quién registró esto
            $table->timestamps(); // Fecha y hora del registro
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_realizados');
    }
};
