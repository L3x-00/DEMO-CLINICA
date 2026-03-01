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
        Schema::table('pacientes', function (Blueprint $table) {
            // Eliminamos las columnas que ya no queremos
            $table->dropColumn(['antecedentes', 'observaciones']);
        });
    }

    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Por si necesitas revertir, las definimos de nuevo
            $table->text('antecedentes')->nullable();
            $table->text('observaciones')->nullable();
        });
    }
};
