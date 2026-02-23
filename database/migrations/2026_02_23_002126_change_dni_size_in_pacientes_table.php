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
    Schema::table('pacientes', function (Blueprint $table) {
        // Cambiamos a string y le damos 20 caracteres para estar sobrados
        $table->string('dni', 20)->change(); 
    });
}

public function down()
{
    Schema::table('pacientes', function (Blueprint $table) {
        $table->string('dni', 8)->change();
    });
}
};
