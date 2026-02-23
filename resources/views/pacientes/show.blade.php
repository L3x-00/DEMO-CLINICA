@extends('layouts.app')

@section('content')
<div class="container pb-5">
    {{-- Cabecera de Acciones --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
        <div class="d-flex gap-2">
            <button onclick="window.print();" class="btn btn-dark shadow-sm">
                <i class="bi bi-printer"></i> Imprimir Ficha
            </button>
            
            <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-warning shadow-sm text-dark">
                <i class="bi bi-pencil-square"></i> Editar Info
            </a>

            {{-- Botón con el ID del paciente para pre-cargar el formulario de citas --}}
            <a href="{{ route('citas.create', ['paciente_id' => $paciente->id]) }}" class="btn btn-success shadow-sm">
                <i class="bi bi-calendar-plus me-1"></i> Agendar Cita
            </a>
        </div>
    </div>

    {{-- Tarjeta Principal de Información --}}
    <div class="card shadow border-0 overflow-hidden">
        {{-- Header: Perfil Principal --}}
        <div class="card-header bg-primary text-white py-4">
            <div class="row align-items-center">
                <div class="col-md-auto text-center mb-3 mb-md-0">
                    <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill fs-1"></i>
                    </div>
                </div>
                <div class="col-md">
                    <h2 class="mb-1 fw-bold">{{ $paciente->apellido }}, {{ $paciente->nombre }}</h2>
                    <p class="mb-0 opacity-75">
                        <i class="bi bi-card-text"></i> {{ $paciente->tipo_documento ?? 'DNI' }}: {{ $paciente->dni }} | 
                        <i class="bi bi-calendar-event"></i> Registro: {{ $paciente->created_at->format('d/m/Y') }}
                    </p>
                </div>
                <div class="col-md-auto text-end">
                    <span class="badge {{ $paciente->sexo == 'Masculino' ? 'bg-info' : 'bg-danger' }} fs-6 px-3 py-2">
                        <i class="bi bi-gender-ambiguous"></i> {{ $paciente->sexo }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Cuerpo de la Ficha --}}
        <div class="card-body p-4 bg-light">
            <div class="row g-4">
                {{-- Columna Izquierda: Información Clínica y Personal --}}
                <div class="col-lg-8">
                    {{-- Datos de Origen --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-info-circle-fill me-2"></i>Información Personal y de Origen
                            </h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="text-muted small d-block">Fecha de Nacimiento</label>
                                    <span class="fw-bold text-dark">{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') : 'No registrada' }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small d-block">Edad Actual</label>
                                    <span class="fw-bold text-dark">{{ $paciente->edad }} años</span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small d-block">Lugar de Nacimiento</label>
                                    <span class="text-dark">{{ $paciente->lugar_nacimiento ?? '---' }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small d-block">Nacionalidad</label>
                                    <span class="text-dark">{{ $paciente->nacionalidad ?? '---' }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small d-block">Estado Civil</label>
                                    <span class="text-dark">{{ $paciente->estado_civil ?? '---' }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small d-block">Procedencia</label>
                                    <span class="text-dark">{{ $paciente->procedencia ?? '---' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Datos de Contacto --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-geo-alt-fill me-2"></i>Ubicación y Contacto
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="text-muted small d-block">Dirección Completa</label>
                                    <span class="text-dark">{{ $paciente->direccion ?? '---' }} ({{ $paciente->localidad ?? 'Sin Localidad' }})</span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small d-block">Teléfono / WhatsApp</label>
                                    <span class="fw-bold text-success">
                                        <i class="bi bi-whatsapp"></i> {{ $paciente->telefono ?? '---' }}
                                    </span>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small d-block">Correo Electrónico</label>
                                    <span class="text-dark">{{ $paciente->email ?? '---' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Alertas Críticas --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-white bg-danger bg-opacity-75 rounded shadow-sm">
                            <h5 class="card-title border-bottom pb-2 mb-3">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Alertas Médicas y Alergias
                            </h5>
                            <p class="fs-5 mb-0 fw-bold">
                                {{ $paciente->alergias ?? 'El paciente no reporta alergias conocidas.' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Información Laboral --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-briefcase-fill me-2"></i>Perfil Laboral
                            </h5>
                            <div class="mb-4">
                                <label class="text-muted small d-block">Profesión</label>
                                <span class="fw-bold text-dark">{{ $paciente->profesion ?? '---' }}</span>
                            </div>
                            <div class="mb-4">
                                <label class="text-muted small d-block">Ocupación Actual</label>
                                <span class="fw-bold text-dark">{{ $paciente->ocupacion ?? '---' }}</span>
                            </div>
                            <div class="mb-4">
                                <label class="text-muted small d-block">Lugar de Labores</label>
                                <span class="fw-bold text-secondary">{{ $paciente->lugar_laboral ?? '---' }}</span>
                            </div>
                            
                            <hr class="mt-auto">
                            
                            <div class="alert alert-info border-0 mb-0 shadow-sm">
                                <h6 class="alert-heading fw-bold"><i class="bi bi-lightbulb"></i> Nota Médica:</h6>
                                <p class="small mb-0">Esta ficha contiene información confidencial protegida por la normativa vigente.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para la impresión */
    @media print {
        .btn, nav, header, aside, .navbar, .sidebar { display: none !important; }
        .container { width: 100% !important; max-width: 100% !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-header { background-color: #0d6efd !important; color: white !important; -webkit-print-color-adjust: exact; }
        .bg-danger { background-color: #dc3545 !important; color: white !important; -webkit-print-color-adjust: exact; }
        body { background-color: white !important; }
    }
</style>
@endsection