@extends('layouts.app')

@section('content')
<div class="container-fluid container-lg mt-4 mb-5">
    {{-- CABECERA ESTILO DASHBOARD --}}
    <div class="row align-items-center mb-4">
        <div class="col-12 col-sm-7 col-md-8 mb-3 mb-sm-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 d-none d-md-block">
                    <i class="bi bi-calendar-check fs-2 text-primary"></i>
                </div>
                <div>
                    <h2 class="fw-bold text-dark mb-0">Agenda de Citas 🦴</h2>
                    <p class="text-muted small mb-0">Control total de turnos y consultas médicas</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-5 col-md-4 text-sm-end">
            <a href="{{ route('citas.create') }}" class="btn btn-primary btn-lg shadow-sm fw-bold w-100 w-sm-auto px-4">
                <i class="bi bi-calendar-plus me-2"></i>Nueva Cita
            </a>
        </div>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 5px solid #198754 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BARRA DE BÚSQUEDA Y FILTRO (FUNCIONALIDAD INTACTA) --}}
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-4">
            <form action="{{ route('citas.index') }}" method="GET" class="row g-3">
                <div class="col-12 col-md-4">
                    <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.7rem;">Filtrar por Fecha 📅</label>
                    <input type="date" name="fecha" class="form-control form-control-lg bg-light border-0 shadow-none" style="font-size: 0.9rem;" value="{{ $fechaBusqueda ?? '' }}">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label small fw-bold text-secondary text-uppercase" style="font-size: 0.7rem;">Buscar Paciente o DNI 🔍</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="buscar" class="form-control form-control-lg bg-light border-0 shadow-none" style="font-size: 0.9rem;" placeholder="Nombre, apellido o DNI..." value="{{ request('buscar') }}">
                        <button class="btn btn-primary px-4" type="submit">Buscar</button>
                    </div>
                </div>
                <div class="col-12 col-md-2 d-grid d-md-flex align-items-end">
                    <a href="{{ route('citas.index') }}" class="btn btn-outline-secondary btn-lg w-100 border-dashed">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA DE CITAS --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="ps-4 py-3 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Fecha y Hora ⏰</th>
                            <th class="fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Paciente 👤</th>
                            <th class="fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Motivo de Consulta</th>
                            <th class="fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Estado 🚦</th>
                            <th class="text-center pe-4 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Gestión</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($citas as $cita)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="calendar-icon me-3 text-center bg-light rounded-3 p-2 border">
                                        <span class="d-block fw-bold text-primary lh-1" style="font-size: 1.1rem;">{{ \Carbon\Carbon::parse($cita->fecha)->format('d') }}</span>
                                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.6rem;">{{ \Carbon\Carbon::parse($cita->fecha)->format('M') }}</small>
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-dark">{{ \Carbon\Carbon::parse($cita->fecha)->format('Y') }}</span>
                                        <small class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10">
                                            <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($cita->paciente)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2 bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                            {{ substr($cita->paciente->nombre, 0, 1) }}{{ substr($cita->paciente->apellido, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</div>
                                            <small class="text-muted">DNI: {{ $cita->paciente->dni }}</small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-danger small fw-bold text-uppercase"><i class="bi bi-exclamation-triangle me-1"></i>No asignado</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-muted" style="max-width: 250px;">
                                    <i class="bi bi-chat-left-text me-1 opacity-50"></i>
                                    <span class="small" title="{{ $cita->motivo }}">
                                        {{ Str::limit($cita->motivo ?? 'Sin motivo especificado', 40) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                {{-- LÓGICA DE COLORES ORIGINAL MANTENIDA --}}
                                @php
                                    $color = [
                                        'Pendiente' => 'bg-warning text-dark',
                                        'Concluido' => 'bg-success text-white',
                                        'No presentado' => 'bg-danger text-white',
                                        'Reprogramado' => 'bg-info text-dark'
                                    ][$cita->estado] ?? 'bg-secondary text-white';
                                @endphp
                                <span class="badge {{ $color }} px-3 py-2 rounded-pill fw-bold shadow-sm" style="font-size: 0.75rem;">
                                    {{ $cita->estado }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm border rounded-3" role="group">
                                    <a href="{{ route('citas.show', $cita->id) }}" class="btn btn-white btn-sm px-3 border-end" title="Detalles">
                                        <i class="bi bi-eye text-info"></i>
                                    </a>
                                    <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-white btn-sm px-3 border-end" title="Editar">
                                        <i class="bi bi-pencil text-warning"></i>
                                    </a>
                                    <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta cita?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm px-3" title="Eliminar">
                                            <i class="bi bi-trash3 text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-calendar-x display-1 text-muted opacity-25"></i>
                                    <h5 class="mt-3 fw-bold text-muted">No hay citas en la agenda</h5>
                                    <p class="text-muted small">Intenta cambiar los filtros o registra una nueva consulta.</p>
                                    <a href="{{ route('citas.create') }}" class="btn btn-primary btn-sm rounded-pill px-4">Crear cita ahora</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection