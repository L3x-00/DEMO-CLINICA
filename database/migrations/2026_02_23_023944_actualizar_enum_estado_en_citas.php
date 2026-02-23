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
    Schema::table('citas', function (Blueprint $table) {
        // Cambiamos el ENUM para incluir los nuevos estados
        $table->enum('estado', ['Pendiente', 'Concluido', 'No presentado', 'Reprogramado'])
              ->default('Pendiente')
              ->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
