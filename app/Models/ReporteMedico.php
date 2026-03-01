<?php
namespace App\Models; // 👈 ¡FALTABA ESTA LÍNEA!
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteMedico extends Model
{
    use HasFactory;

    protected $table = 'reportes_medicos';

    protected $fillable = [
        'paciente_id',
        'examen_fisico_preferencial',
        'examen_auxiliar',
        'diagnostico',
        'cie_10',
        'tratamiento',
        'evolucion',
        'recomendaciones',
        'fecha',
        'doctor'
    ];

    // Relación inversa: Un reporte pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}