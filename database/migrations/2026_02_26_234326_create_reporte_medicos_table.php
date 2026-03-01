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
        Schema::create('reportes_medicos', function (Blueprint $table) {
            $table->id();
            // Relación con el paciente
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            
            // Campos del informe
            $table->text('examen_fisico_preferencial')->nullable();
            $table->text('examen_auxiliar')->nullable();
            $table->text('diagnostico')->nullable();
            $table->string('cie_10')->nullable(); // Código internacional de enfermedades
            $table->text('tratamiento')->nullable();
            $table->text('evolucion')->nullable();
            $table->text('recomendaciones')->nullable();
            
            // Metadatos automáticos
            $table->date('fecha');
            $table->string('doctor'); // Nombre del doctor logueado
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_medicos');
    }
};
