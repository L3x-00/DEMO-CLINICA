<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('users'); // El doctor asignado
            $table->string('servicio'); // "Consulta Médica", "Ecografía", etc.
            $table->decimal('costo_servicio', 8, 2);
            $table->decimal('descuento', 8, 2)->default(0);
            $table->decimal('total_pagado', 8, 2);
            $table->enum('estado', ['En Espera', 'Atendido', 'Cancelado'])->default('En Espera');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencions');
    }
};
