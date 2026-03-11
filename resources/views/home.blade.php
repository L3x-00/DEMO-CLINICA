@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4 mb-5 px-md-5">
    {{-- CABECERA DEL DASHBOARD --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-0">
                <span class="text-primary">Hola,</span> 
                @if(auth()->user()->role === 'doctor')
                    Dr. {{ auth()->user()->name }} 🩺
                @else
                    {{ auth()->user()->name }} (Asistente) 📋
                @endif
                👋
            </h2>
        </div>
        
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                <a href="{{ route('pacientes.index') }}" 
                class="btn bg-body-secondary text-body-emphasis border px-3 d-inline-flex align-items-center">
                    <i class="bi bi-people me-2 text-primary"></i> Pacientes
                </a>
                <a href="{{ route('pacientes.create') }}" 
                class="btn btn-primary px-3 d-inline-flex align-items-center">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Registro
                </a>
            </div>
        </div>
    </div>

    {{-- TARJETAS DE ESTADÍSTICAS --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted small text-uppercase fw-bold ls-1">Citas para Hoy</h6>
                            <h2 class="fw-bold mb-0 mt-2">{{ $citasHoyCount }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 h-100">
                            <i class="bi bi-calendar2-event fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted small text-uppercase fw-bold ls-1">Atendidos Hoy</h6>
                            <h2 class="fw-bold mb-0 mt-2 text-success">{{ $atendidosHoy }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 h-100">
                            <i class="bi bi-person-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted small text-uppercase fw-bold ls-1">Rendimiento vs Ayer</h6>
                            <h2 class="fw-bold mb-0 mt-2">{{ $atendidosAyer }} <small class="fs-6 fw-normal text-muted">atenciones</small></h2>
                        </div>
                        <div class="bg-dark bg-opacity-10 text-dark p-3 rounded-4 h-100">
                            <i class="bi bi-activity fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN DE GRÁFICOS --}}
    <div class="row mb-4">
        <div class="col-lg-5 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-pie-chart me-2 text-primary"></i>Estado de Atención</h6>
                    <div style="height: 280px; position: relative;">
                        {{-- Pasamos datos vía data-attributes --}}
                        <canvas id="chartAtencionHoy" 
                                data-atendidos="{{ $atendidosHoy }}" 
                                data-pendientes="{{ max(0, $citasHoyCount - $atendidosHoy) }}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-bar-chart me-2 text-primary"></i>Comparativa (Hoy vs Ayer)</h6>
                    <div style="height: 280px;">
                        <canvas id="chartComparativoAtencion"
                                data-ayer="{{ $atendidosAyer }}"
                                data-hoy="{{ $atendidosHoy }}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN DE AGENDA --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-calendar-range me-2 text-primary"></i>Próximas Atenciones (7 días)
            </h5>
            <span class="badge rounded-pill bg-body-secondary text-body-emphasis border px-3">
                En agenda: {{ $proximasCitas->count() }}
            </span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Horario</th>
                        <th class="py-3">Paciente</th>
                        <th class="py-3">Documento</th>
                        <th class="py-3 text-center">Acción / Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proximasCitas as $cita)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</div>
                            <div class="text-muted small">
                                <i class="bi bi-clock-history me-1"></i>{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</div>
                            <a href="{{ route('pacientes.show', $cita->paciente->id) }}" class="text-decoration-none small fw-medium">Ver Historia Clínica</a>
                        </td>
                        <td>
                            <span class="badge bg-body-secondary text-body-secondary border-0 fw-normal">
                                DNI: {{ $cita->paciente->dni }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary rounded-pill dropdown-toggle px-3" type="button" data-bs-toggle="dropdown">
                                    @if($cita->estado == 'Pendiente')
                                        <span class="text-warning fw-bold">⏳ Pendiente</span>
                                    @elseif($cita->estado == 'Concluido')
                                        <span class="text-success fw-bold">✅ Concluido</span>
                                    @elseif($cita->estado == 'No presentado')
                                        <span class="text-danger fw-bold">❌ No asistió</span>
                                    @else
                                        <span class="text-info fw-bold">{{ $cita->estado }}</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu shadow border-0 p-2">
                                    <li><h6 class="dropdown-header">Actualizar estado:</h6></li>
                                    <li>
                                        <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="estado" value="Concluido">
                                            <button type="submit" class="dropdown-item rounded py-2">
                                                <i class="bi bi-check-circle text-success me-2"></i> Marcar Concluido
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="estado" value="No presentado">
                                            <button type="submit" class="dropdown-item rounded py-2 text-danger">
                                                <i class="bi bi-x-circle me-2"></i> No asistió
                                            </button>
                                        </form>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button type="button" class="dropdown-item rounded py-2" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalReprogramar" 
                                                data-cita-id="{{ $cita->id }}"
                                                data-paciente="{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}">
                                            <i class="bi bi-calendar-event text-primary me-2"></i> Reprogramar Cita
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted opacity-50">
                                <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                                <p class="mb-0">No hay compromisos en la agenda para los próximos días.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL REPROGRAMAR --}}
<div class="modal fade" id="modalReprogramar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-range me-2 text-primary"></i>Reprogramar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formReprogramar" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-4">
                    <p class="text-muted small">Reprogramando cita para: <strong id="nombrePacienteModal" class="text-dark"></strong></p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nueva Fecha</label>
                            <input type="date" name="fecha" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nueva Hora</label>
                            <input type="time" name="hora" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Motivo del Cambio</label>
                            <textarea name="motivo" class="form-control" rows="3" placeholder="Ej: Solicitud del paciente..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light text-muted px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Confirmar Cambio</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 0.5px; }
    .table-hover tbody tr:hover { background-color: rgba(13, 110, 253, 0.02) !important; }
    .dropdown-item:active { background-color: #0d6efd; }
</style>

@push('scripts')
    @vite(['resources/js/pages/dashboard.js'])
@endpush

@endsection