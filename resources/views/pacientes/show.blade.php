@extends('layouts.app')

@section('content')
<div class="container pb-5 mt-4">
    {{-- BARRA DE ACCIONES SUPERIOR --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3 no-print">
        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm w-fit">
            <i class="bi bi-arrow-left me-1"></i> Volver al Listado
        </a>
        
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('reportes.create', ['paciente_id' => $paciente->id]) }}" class="btn btn-success shadow-sm">
                <i class="bi bi-file-earmark-plus"></i> Generar Informe
            </a>
            <div class="d-flex gap-2 shadow-sm p-1 bg-body-tertiary rounded border">
                <button onclick="window.print();" class="btn btn-outline-secondary btn-sm border-0">
                    <i class="bi bi-printer me-1"></i> Imprimir
                </button>
                <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-warning btn-sm text-dark px-3 fw-bold">
                    <i class="bi bi-pencil-square me-1"></i> Editar
                </a>
                <button type="button" class="btn btn-primary btn-sm px-3 fw-bold"
                    onclick="agendarCitaDesdePaciente({{ $paciente->id }}, '{{ $paciente->nombre }}', '{{ $paciente->apellido }}', '{{ $paciente->dni }}')">
                    <i class="bi bi-calendar-plus me-1"></i> Agendar Cita
                </button>
            </div>
        </div>
    </div>

    {{-- TARJETA MAESTRA DEL EXPEDIENTE --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden" style="background-color: var(--card-bg);">
        {{-- CABECERA DE PERFIL --}}
        <div class="card-header border-0 py-4 px-4 bg-primary text-white">
            <div class="row align-items-center">
                <div class="col-md-auto mb-3 mb-md-0 text-center">
                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 80px; height: 80px; font-size: 2.5rem;">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                </div>
                <div class="col-md text-center text-md-start">
                    <h2 class="mb-1 fw-bold">{{ $paciente->apellido }}, {{ $paciente->nombre }}</h2>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 small opacity-75">
                        <span><i class="bi bi-card-text"></i> {{ $paciente->tipo_documento ?? 'DNI' }}: {{ $paciente->dni }}</span>
                        <span><i class="bi bi-calendar3"></i> {{ $paciente->edad }} años</span>
                        <span><i class="bi bi-gender-ambiguous"></i> {{ $paciente->sexo }}</span>
                    </div>
                </div>
                <div class="col-md-auto text-end mt-3 mt-md-0">
                    <span class="badge bg-white text-primary fw-bold px-3 py-2 rounded-pill">
                        ID: #{{ str_pad($paciente->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">
                {{-- COLUMNA IZQUIERDA: CLÍNICA --}}
                <div class="col-lg-8">
                    {{-- Alerta de Motivo/Alergias --}}
                    <div class="alert {{ $paciente->alergias ? 'alert-danger shadow-sm' : 'bg-body-secondary' }} border-start border-4 mb-4">
                        <h6 class="alert-heading fw-bold mb-2">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i>Motivo de la consulta / Alergias
                        </h6>
                        <p class="mb-0 fs-5 fw-medium">
                            {{ $paciente->alergias ?? 'Sin observaciones preventivas registradas.' }}
                        </p>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body-secondary small fw-bold mb-3">Información de Origen</h6>
                            <div class="p-3 rounded-3 bg-body-tertiary border">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-body-secondary small">Nacimiento:</span>
                                    <span class="fw-bold">{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') : '---' }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-body-secondary small">Nacionalidad:</span>
                                    <span class="fw-bold">{{ $paciente->nacionalidad ?? 'Peruana' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body-secondary small fw-bold mb-3">Contacto Directo</h6>
                            <div class="p-3 rounded-3 bg-success-subtle border border-success-subtle">
                                <span class="text-body-secondary small d-block">WhatsApp / Celular:</span>
                                <span class="fs-5 fw-bold text-success">
                                    <i class="bi bi-whatsapp"></i> {{ $paciente->telefono ?? 'No registrado' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Evidencia Fotográfica --}}
                    <h6 class="text-uppercase text-body-secondary small fw-bold mb-3">Evidencia Médica Relacionada</h6>
                    @if($paciente->evidencia)
                        <div class="rounded-4 overflow-hidden border shadow-sm">
                            <img src="{{ asset('storage/' . $paciente->evidencia) }}" class="img-fluid w-100" style="max-height: 500px; object-fit: contain; background: #f8f9fa;">
                        </div>
                    @else
                        <div class="p-5 text-center border-dashed rounded-4 bg-body-tertiary opacity-75">
                            <i class="bi bi-camera-video-off fs-1 d-block mb-2"></i>
                            <span class="small">No hay imágenes cargadas en este expediente</span>
                        </div>
                    @endif
                </div>

                {{-- COLUMNA DERECHA: ESTADÍSTICAS / INFO EXTRA --}}
                <div class="col-lg-4">
                    <div class="card border-0 bg-body-tertiary h-100">
                        <div class="card-body">
                            <h6 class="fw-bold mb-4">Resumen de Actividad</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-shape bg-primary-subtle text-primary rounded me-3 p-2">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <small class="text-body-secondary d-block">Registrado el:</small>
                                    <span class="fw-bold small">{{ $paciente->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            <hr class="opacity-25">
                            <div class="alert alert-info border-0 small">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Los datos aquí mostrados son privados. Recuerde cerrar sesión al terminar.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PIE DE PÁGINA --}}
        <div class="card-footer bg-body-tertiary border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <small class="text-body-secondary">Actualizado: {{ $paciente->updated_at->diffForHumans() }}</small>
            
            <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" class="no-print" onsubmit="return confirm('¿Eliminar historia clínica definitivamente?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link text-danger btn-sm text-decoration-none p-0">
                    <i class="bi bi-trash3"></i> Eliminar Registro Permanente
                </button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    {{-- 1. Librerías externas (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- 2. Tus scripts compilados con Vite --}}
    @vite(['resources/js/pages/citas.js'])
    
    {{-- Solo en index.blade.php agregarías el de pacientes.js si tiene lógica extra --}}
    @if(Route::is('pacientes.index'))
        @vite(['resources/js/pages/pacientes.js'])
    @endif
@endpush
@endsection