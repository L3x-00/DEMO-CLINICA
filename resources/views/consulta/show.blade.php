@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-file-earmark-medical text-primary me-2"></i>Detalle de Consulta</h2>
            <p class="text-muted mb-0">Consulta N° {{ $consulta->numero_consulta }} — Paciente: <strong>{{ $consulta->paciente->nombre }} {{ $consulta->paciente->apellido }}</strong></p>
        </div>
        <div class="d-flex gap-2 d-print-none">
            <a href="{{ route('pacientes.index') }}" class="btn  btn-outline-dark border shadow-sm">
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
        {{-- Columna Principal: Evolución Clínica --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3 text-primary"><i class="bi bi-journal-medical me-2"></i>1. Anamnesis y Evolución</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Motivo de Consulta</label>
                            <p class=" p-3 rounded-3 border-start border-primary ">{{ $consulta->motivo_consulta }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold text-uppercase">Tiempo de Enfermedad</label>
                            <p class="border-bottom pb-1">{{ $consulta->tiempo_enfermedad ?? 'No registrado' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-bold text-uppercase">Estado de Ánimo</label>
                            <p class="border-bottom pb-1">{{ $consulta->estado_animo ?? 'Normal' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Examen Físico General</label>
                            <p class="p-2 border rounded-3 text-muted small">{{ $consulta->examen_fisico ?? 'Sin observaciones particulares.' }}</p>
                        </div>
                    </div>

                    <h5 class="fw-bold border-bottom pb-2 mb-3 mt-4 text-primary"><i class="bi bi-Stethoscope me-2"></i>2. Diagnóstico y Tratamiento</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Diagnóstico Definitivo</label>
                            <p class="bg-primary bg-opacity-10 p-3 rounded-3 fw-bold text-primary">{{ $consulta->diagnostico }}</p>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Tratamiento / Plan de Trabajo</label>
                            <div class="p-3 border rounded-3  shadow-sm" style="min-height: 100px; border-left: 4px solid #198754 !important;">
                                {!! nl2br(e($consulta->tratamiento)) !!}
                            </div>
                        </div>
                        @if($consulta->examenes_auxiliares)
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Exámenes Auxiliares</label>
                            <p class="small border-bottom pb-1">{{ $consulta->examenes_auxiliares }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Pie de página de la consulta --}}
            <div class="d-flex justify-content-between text-muted small px-2">
                <span><i class="bi bi-person-check me-1"></i>Atendido por: <strong>{{ $consulta->atendido_por }}</strong></span>
                <span><i class="bi bi-calendar3 me-1"></i>Fecha: {{ \Carbon\Carbon::parse($consulta->fecha_registro)->format('d/m/Y') }} - {{ $consulta->hora_registro }}</span>
            </div>
        </div>

        {{-- Columna Lateral: Constantes y Funciones --}}
        <div class="col-lg-4">
            {{-- Funciones Vitales --}}
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-activity text-warning me-2"></i>Funciones Vitales</h5>
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="bg-white bg-opacity-10 rounded-3 p-2 border border-white border-opacity-10">
                                <small class="d-block  small fw-bold">Temp.</small>
                                <span class="fs-5 fw-bold">{{ $consulta->temperatura }}°C</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-10 rounded-3 p-2 border border-white border-opacity-10">
                                <small class="d-block small fw-bold">P. Arterial</small>
                                <span class="fs-5 fw-bold">{{ $consulta->presion_arterial }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-10 rounded-3 p-2 border border-white border-opacity-10">
                                <small class="d-block  small fw-bold">F. Resp.</small>
                                <span class="fs-5 fw-bold">{{ $consulta->frecuencia_respiratoria }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-10 rounded-3 p-2 border border-white border-opacity-10">
                                <small class="d-block  small fw-bold">F. Cardíaca</small>
                                <span class="fs-5 fw-bold">{{ $consulta->frecuencia_cardiaca }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-10 rounded-3 p-2 border border-white border-opacity-10">
                                <small class="d-block  small fw-bold">Peso</small>
                                <span class="fs-5 fw-bold">{{ $consulta->peso }} <small>kg</small></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-10 rounded-3 p-2 border border-white border-opacity-10">
                                <small class="d-block  small fw-bold">Talla</small>
                                <span class="fs-5 fw-bold">{{ $consulta->talla }} <small>cm</small></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Funciones Biológicas --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-secondary mb-3 small text-uppercase">Funciones Biológicas</h5>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between px-0">Apetito: <span class="fw-bold">{{ $consulta->apetito ?? 'Normal' }}</span></li>
                        <li class="list-group-item d-flex justify-content-between px-0">Sed: <span class="fw-bold">{{ $consulta->sed ?? 'Normal' }}</span></li>
                        <li class="list-group-item d-flex justify-content-between px-0">Sueño: <span class="fw-bold">{{ $consulta->sueno ?? 'Normal' }}</span></li>
                        <li class="list-group-item d-flex justify-content-between px-0">Orina: <span class="fw-bold">{{ $consulta->orina ?? 'Normal' }}</span></li>
                        <li class="list-group-item d-flex justify-content-between px-0">Deposiciones: <span class="fw-bold">{{ $consulta->deposiciones ?? 'Normal' }}</span></li>
                    </ul>
                </div>
            </div>

            {{-- Referencia --}}
            @if($consulta->proxima_cita)
            <div class="alert alert-info mt-4 rounded-4 border-0 shadow-sm">
                <i class="bi bi-calendar-event me-2"></i> Próxima cita sugerida: <strong>{{ \Carbon\Carbon::parse($consulta->proxima_cita)->format('d/m/Y') }}</strong>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection