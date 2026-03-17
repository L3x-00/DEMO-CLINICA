<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Atencion extends Model {
    protected $table = 'atenciones';
    protected $guarded = [];

    public function paciente() {
        return $this->belongsTo(Paciente::class);
    }
}