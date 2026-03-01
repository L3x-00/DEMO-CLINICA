@extends('layouts.app')

@section('content')
<div class="container-fluid container-lg mt-4 mb-5">
    {{-- CABECERA MODERNA --}}
    <div class="row align-items-center mb-4">
        <div class="col-12 col-sm-7 col-md-8 mb-3 mb-sm-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 d-none d-md-block">
                    <i class="bi bi-file-earmark-medical fs-2 text-primary"></i>
                </div>
                <div>
                    <h2 class="fw-bold text-dark mb-0">Informes Médicos</h2>
                    <p class="text-muted small mb-0">
                        <span class="badge bg-primary-subtle text-primary rounded-pill me-2">{{ count($reportes) }} Registros</span>
                        Historial de evaluaciones y evoluciones clínicas
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-5 col-md-4 text-sm-end">
            <a href="{{ route('reportes.create') }}" class="btn btn-success btn-lg shadow-sm fw-bold w-100 w-sm-auto px-4">
                <i class="bi bi-plus-lg me-2"></i>Nuevo Informe
            </a>
        </div>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 5px solid #198754 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                <div>
                    <strong class="d-block">¡Operación Exitosa!</strong>
                    {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BARRA DE FILTROS RÁPIDOS --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" id="filterInput" placeholder="Buscar por paciente o diagnóstico...">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-8 text-md-end">
                    <div class="btn-group shadow-sm">
                        <button class="btn btn-outline-secondary btn-sm active">Todos</button>
                        <button class="btn btn-outline-secondary btn-sm">Hoy</button>
                        <button class="btn btn-outline-secondary btn-sm">Mes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA DE REPORTES REORGANIZADA --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 950px;">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold">Fecha Emisión</th>
                            <th class="text-secondary small text-uppercase fw-bold">Información del Paciente</th>
                            <th class="text-secondary small text-uppercase fw-bold">DNI / ID</th>
                            <th class="text-secondary small text-uppercase fw-bold">Diagnóstico Clínico</th>
                            <th class="text-secondary small text-uppercase fw-bold">CIE-10</th>
                            <th class="text-secondary small text-uppercase fw-bold">Especialista</th>
                            <th class="text-center pe-4 text-secondary small text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($reportes as $reporte)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($reporte->fecha)->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                        {{ substr($reporte->paciente->nombre, 0, 1) }}{{ substr($reporte->paciente->apellido, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $reporte->paciente->nombre }} {{ $reporte->paciente->apellido }}</div>
                                        <small class="text-muted"><i class="bi bi-calendar2-event me-1"></i>{{ \Carbon\Carbon::parse($reporte->paciente->fecha_nacimiento)->age }} años</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-2">
                                    <i class="bi bi-person-vcard me-1"></i>{{ $reporte->paciente->dni }}
                                </span>
                            </td>
                            <td>
                                <div class="text-dark fw-medium" style="max-width: 280px;">
                                    <span class="d-inline-block text-truncate w-100" title="{{ $reporte->diagnostico }}">
                                        {{ $reporte->diagnostico }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">
                                    {{ $reporte->cie_10 ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-stethoscope me-2 text-primary"></i>
                                    <small class="fw-bold text-uppercase" style="font-size: 0.75rem;">Dr. {{ $reporte->doctor }}</small>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('reportes.show', $reporte->id) }}" class="btn btn-white btn-sm border shadow-sm px-3 hover-primary" title="Imprimir Informe">
                                        <i class="bi bi-printer text-primary me-1"></i> <span class="small fw-bold">Imprimir</span>
                                    </a>
                                    
                                    <form action="{{ route('reportes.destroy', $reporte->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este registro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 shadow-none" title="Eliminar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="opacity-50 mb-3">
                                    <i class="bi bi-clipboard2-x fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-muted">Sin informes registrados</h5>
                                <p class="text-muted small">No se han generado evaluaciones clínicas en el sistema todavía.</p>
                                <a href="{{ route('reportes.create') }}" class="btn btn-primary btn-sm mt-2">Crear primer reporte</a>
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