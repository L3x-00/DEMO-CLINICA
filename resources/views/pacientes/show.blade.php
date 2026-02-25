@extends('layouts.app')

@section('content')
<div class="container pb-5 mt-4">
    {{-- BARRA DE ACCIONES SUPERIOR --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm w-fit">
            <i class="bi bi-arrow-left me-1"></i> Volver al Listado
        </a>
        <div class="d-flex gap-2 shadow-sm p-1 bg-white rounded">
            <button onclick="window.print();" class="btn btn-light btn-sm border text-secondary">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
            <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-warning btn-sm text-dark px-3">
                <i class="bi bi-pencil-square me-1"></i> Editar
            </a>
            <a href="{{ route('citas.create', ['paciente_id' => $paciente->id]) }}" class="btn btn-primary btn-sm px-3 fw-bold">
                <i class="bi bi-calendar-plus me-1"></i> Agendar Cita
            </a>
        </div>
    </div>

    {{-- TARJETA MAESTRA --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        {{-- HEADER: PERFIL DESTACADO --}}
        <div class="card-header bg-primary py-4 px-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-auto mb-3 mb-md-0 text-center">
                    <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px;">
                        <i class="bi bi-person-badge-fill fs-2"></i>
                    </div>
                </div>
                <div class="col-md text-white text-center text-md-start">
                    <h2 class="mb-1 fw-bold">{{ $paciente->apellido }}, {{ $paciente->nombre }}</h2>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 opacity-90 small">
                        <span><i class="bi bi-card-text me-1"></i> {{ $paciente->tipo_documento ?? 'DNI' }}: {{ $paciente->dni }}</span>
                        <span><i class="bi bi-calendar3 me-1"></i> {{ $paciente->edad }} años</span>
                        <span><i class="bi bi-clock-history me-1"></i> Registrado: {{ $paciente->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="col-md-auto text-end mt-3 mt-md-0">
                    <span class="badge {{ $paciente->sexo == 'Masculino' ? 'bg-info' : 'bg-danger' }} rounded-pill px-4 py-2 shadow-sm">
                        <i class="bi bi-gender-ambiguous me-1"></i> {{ $paciente->sexo }}
                    </span>
                </div>
            </div>
        </div>

        {{-- CUERPO PRINCIPAL --}}
        <div class="card-body p-4 bg-white">
            <div class="row g-4">
                
                {{-- COLUMNA IZQUIERDA --}}
                <div class="col-lg-8">
                    {{-- SECCIÓN: DATOS MÉDICOS CRÍTICOS --}}
                    <div class="alert {{ $paciente->alergias ? 'alert-danger' : 'alert-light border' }} border-start border-4 mb-4 shadow-sm">
                        <h6 class="alert-heading fw-bold"><i class="bi bi-exclamation-octagon-fill me-2"></i>Alergias y Observaciones Críticas</h6>
                        <p class="mb-0 fs-5 fw-medium text-dark">
                            {{ $paciente->alergias ?? 'No reporta alergias conocidas.' }}
                        </p>
                    </div>

                    {{-- ANTECEDENTES Y OBSERVACIONES --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 bg-light rounded-3 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold text-danger small text-uppercase"><i class="bi bi-clipboard2-pulse-fill me-2"></i>Antecedentes</h6>
                                    <p class="mb-0 text-dark">{{ $paciente->antecedentes ?? 'Sin antecedentes registrados.' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 bg-light rounded-3 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary small text-uppercase"><i class="bi bi-info-circle-fill me-2"></i>Observaciones</h6>
                                    <p class="mb-0 text-dark">{{ $paciente->observaciones ?? 'Sin observaciones.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        {{-- Bloque: Información Personal --}}
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3 ls-1">Información de Origen</h6>
                            <ul class="list-group list-group-flush border-top small">
                                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Fecha Nacimiento:</span>
                                    <span class="fw-bold text-dark">{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') : '---' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Estado Civil:</span>
                                    <span class="text-dark">{{ $paciente->estado_civil ?? '---' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Nacionalidad:</span>
                                    <span class="text-dark">{{ $paciente->nacionalidad ?? '---' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Lugar de Origen:</span>
                                    <span class="text-dark">{{ $paciente->lugar_nacimiento ?? '---' }}</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Bloque: Ubicación --}}
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3 ls-1">Residencia Actual</h6>
                            <div class="p-3 bg-light rounded-3 border">
                                <p class="mb-1 fw-bold text-dark small"><i class="bi bi-geo-alt me-1"></i>Dirección:</p>
                                <p class="small text-secondary mb-2">{{ $paciente->direccion ?? 'No registrada' }}</p>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="small text-muted d-block">Provincia</label>
                                        <span class="small fw-bold text-dark text-uppercase">{{ $paciente->provincia ?? '---' }}</span>
                                    </div>
                                    <div class="col-6 border-start ps-3">
                                        <label class="small text-muted d-block">Distrito</label>
                                        <span class="small fw-bold text-dark text-uppercase">{{ $paciente->distrito ?? '---' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bloque: Contacto --}}
                    <div class="mt-4 p-3 border rounded-3 bg-white shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <span class="text-muted small d-block">WhatsApp / Teléfono</span>
                                <span class="fs-5 fw-bold text-success"><i class="bi bi-whatsapp"></i> {{ $paciente->telefono ?? '---' }}</span>
                            </div>
                            <div class="col-md-6 border-start-md ps-md-4">
                                <span class="text-muted small d-block">Correo Electrónico</span>
                                <span class="text-dark fw-medium">{{ $paciente->email ?? 'Sin correo registrado' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN DE EVIDENCIA (Dentro de la columna principal) --}}
                    <div class="card border-0 shadow-sm rounded-4 mt-4 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3 text-uppercase small ls-1"><i class="bi bi-image me-2 text-primary"></i>Evidencia Médica</h6>
                            @if($paciente->evidencia)
                                <div class="evidencia-container">
                                    <img src="{{ asset('storage/' . $paciente->evidencia) }}" 
                                         class="img-fluid rounded-3 border shadow-sm" 
                                         alt="Evidencia del paciente">
                                </div>
                            @else
                                <div class="bg-white rounded-3 p-5 text-center text-muted border-dashed shadow-sm">
                                    <i class="bi bi-image-fill fs-1 d-block mb-2 opacity-50"></i>
                                    Sin evidencia fotográfica registrada.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA --}}
                <div class="col-lg-4">
                    <div class="card bg-light border-0 rounded-3 h-100">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3 ls-1">Perfil Laboral</h6>
                            
                            <div class="bg-white p-3 rounded-3 shadow-sm mb-3">
                                <label class="text-muted small d-block mb-1">Profesión</label>
                                <span class="fw-bold text-primary d-block">{{ $paciente->profesion ?? '---' }}</span>
                            </div>

                            <div class="bg-white p-3 rounded-3 shadow-sm mb-3">
                                <label class="text-muted small d-block mb-1">Ocupación Actual</label>
                                <span class="fw-bold text-dark d-block">{{ $paciente->ocupacion ?? '---' }}</span>
                            </div>

                            <div class="bg-white p-3 rounded-3 shadow-sm mb-3">
                                <label class="text-muted small d-block mb-1">Centro Laboral</label>
                                <span class="fw-bold text-secondary d-block">{{ $paciente->lugar_laboral ?? '---' }}</span>
                            </div>

                            <div class="mt-4">
                                <div class="alert alert-info border-0 small mb-0 shadow-sm">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Esta ficha contiene información sensible y está protegida por normativa.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- FOOTER CON BOTÓN ELIMINAR --}}
        <div class="card-footer bg-light border-0 py-3 px-4 mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Última actualización: {{ $paciente->updated_at->diffForHumans() }}</span>
                
                <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" onsubmit="return confirm('¿Está COMPLETAMENTE seguro de eliminar esta historia clínica? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger btn-sm text-decoration-none fw-bold">
                        <i class="bi bi-trash3 me-1"></i> Eliminar Registro
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
    .w-fit { width: fit-content; }
    .border-start-md { border-left: 1px solid #dee2e6; }
    
    .evidencia-container {
        max-width: 100%;
        margin: 0 auto;
        text-align: center;
    }
    .evidencia-container img {
        max-height: 400px; /* Tamaño máximo equilibrado */
        width: auto;
        border-radius: 12px;
        transition: transform 0.3s ease;
    }
    .evidencia-container img:hover {
        transform: scale(1.02);
    }
    .border-dashed {
        border: 2px dashed #dee2e6;
    }

    @media (max-width: 768px) {
        .border-start-md { border-left: none; }
    }

    @media print {
        .btn, nav, .navbar, .card-footer, header, .alert-info { display: none !important; }
        .container { width: 100% !important; max-width: 100% !important; padding: 0 !important; margin-top: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-header { background-color: #0d6efd !important; color: white !important; -webkit-print-color-adjust: exact; }
        body { background-color: white !important; }
    }
</style>
@endsection