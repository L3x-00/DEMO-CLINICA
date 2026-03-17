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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id'); // Relación con pacientes
            $table->integer('numero_consulta'); // Auto-incremental por paciente o global
            
            // Campos autocompletados del registro (Cita/Paciente)
            $table->date('fecha_registro');
            $table->time('hora_registro');
            $table->string('edad_momento');

            // Funciones biológicas y Anamnesis
            $table->text('motivo_consulta')->nullable();
            $table->string('tiempo_enfermedad')->nullable();
            $table->string('apetito')->nullable();
            $table->string('sed')->nullable();
            $table->string('sueno')->nullable();
            $table->string('estado_animo')->nullable();
            $table->string('orina')->nullable();
            $table->string('deposiciones')->nullable();

            // Examen Físico y Funciones Vitales
            $table->text('examen_fisico')->nullable();
            $table->string('temperatura')->nullable();
            $table->string('presion_arterial')->nullable();
            $table->string('frecuencia_respiratoria')->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->string('peso')->nullable();
            $table->string('talla')->nullable();

            // Diagnóstico y Plan
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('examenes_auxiliares')->nullable();
            $table->string('referencia_lugar_motivo')->nullable();
            $table->date('proxima_cita')->nullable();
            
            // Datos del Doctor (Atendido por)
            $table->string('atendido_por'); 
            $table->string('doctor_apellidos');
            $table->string('doctor_nombres');
            
            $table->text('observacion')->nullable();

            $table->timestamps();

            // Clave foránea
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
