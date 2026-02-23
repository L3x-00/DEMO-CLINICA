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
    Schema::create('citas', function (Blueprint $table) {
        $table->id();
        
        // Relación con Pacientes: Aquí está la llave foránea
        $table->foreignId('paciente_id')
              ->constrained('pacientes') // Se conecta con la tabla pacientes
              ->onDelete('cascade');     // Si se borra el paciente, se borran sus citas
        
        $table->date('fecha');
        $table->time('hora');
        $table->string('motivo');        // Ejemplo: "Chequeo general"
        $table->text('observaciones')->nullable(); // Tus notas médicas
        $table->enum('estado', ['Pendiente', 'Completada', 'Cancelada'])->default('Pendiente');
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
