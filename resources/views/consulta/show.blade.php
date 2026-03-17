@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-file-earmark-medical text-primary me-2"></i>Detalle de Consulta</h2>
            <p class="text-muted mb-0">Consulta N° {{ $consulta->numero_consulta }} - Paciente: {{ $consulta->paciente->nombre }} {{ $consulta->paciente->apellido }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pacientes.index') }}" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <button onclick="window.print()" class="btn btn-outline-dark shadow-sm">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
            <a href="{{ route('consulta.edit', $consulta->id) }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Editar
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3 text-primary">Anamnesis y Evolución</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold">Motivo de Consulta</label>
                            <p class="bg-light p-3 rounded-3">{{ $consulta->motivo_consulta }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold">Tiempo de Enfermedad</label>
                            <p class="border-bottom pb-1">{{ $consulta->tiempo_enfermedad ?? 'No registrado' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold">Estado de Ánimo</label>
                            <p class="border-bottom pb-1">{{ $consulta->estado_animo ?? 'Normal' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold">Diagnóstico</label>
                            <p class="bg-light p-3 rounded-3 fw-bold text-dark">{{ $consulta->diagnostico }}</p>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold">Tratamiento / Receta</label>
                            <div class="p-3 border rounded-3 bg-white">
                                {!! nl2br(e($consulta->tratamiento)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-activity me-2"></i>Funciones Vitales</h5>
                    <div class="row text-center g-3">
                        <div class="col-6">
                            <div class="bg-white bg-opacity-25 rounded-3 p-2">
                                <small class="d-block">Temp.</small>
                                <span class="fs-5 fw-bold">{{ $consulta->temperatura }}°C</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-25 rounded-3 p-2">
                                <small class="d-block">P. Arterial</small>
                                <span class="fs-5 fw-bold">{{ $consulta->presion_arterial }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-25 rounded-3 p-2">
                                <small class="d-block">F. Cardíaca</small>
                                <span class="fs-5 fw-bold">{{ $consulta->frecuencia_cardiaca }} lpm</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-25 rounded-3 p-2">
                                <small class="d-block">Peso</small>
                                <span class="fs-5 fw-bold">{{ $consulta->peso }} kg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-secondary mb-3">Funciones Biológicas</h5>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between">Apetito: <span>{{ $consulta->apetito }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">Sed: <span>{{ $consulta->sed }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">Sueño: <span>{{ $consulta->sueno }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">Orina: <span>{{ $consulta->orina }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">Deposiciones: <span>{{ $consulta->deposiciones }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection