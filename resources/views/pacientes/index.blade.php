@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/clinica.css') }}">
@endpush

@section('content')
<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-lg-12">
            {{-- CABECERA Y FILTROS --}}
            <div class="card border-0 shadow-sm mb-4 rounded-4">
                <div class="card-body py-3">
                    <div class="row align-items-center g-3">
                        <div class="col-md-4">
                            <h4 class="mb-0 fw-bold text-primary">Pacientes</h4>
                            <p class="text-muted small mb-0">Gestión centralizada de registros médicos</p>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ route('pacientes.index') }}" method="GET" class="row g-2 justify-content-end">
                                <div class="col-auto">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text  text-primary border-primary-subtle">
                                            <i class="bi bi-calendar-event"></i>
                                        </span>
                                        <input type="date" name="fecha" class="form-control border-primary-subtle shadow-none" 
                                               value="{{ $fechaBusqueda }}" onchange="this.form.submit()">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="buscar" class="form-control border-primary-subtle shadow-none" 
                                               placeholder="Buscar por DNI o Apellido..." value="{{ request('buscar') }}">
                                        <button type="submit" class="btn btn-primary px-3 shadow-sm">
                                            <i class="bi bi-search"></i>
                                        </button>
                                        @if(request('buscar') || request('fecha'))
                                            <a href="{{ route('pacientes.index') }}" class="btn btn-outline-danger" title="Limpiar filtros">
                                                <i class="bi bi-eraser"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLA DE RESULTADOS --}}
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header  border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-person-lines-fill me-2 text-primary"></i> 
                        <span class="text-secondary small text-uppercase">Resultados:</span> 
                        <span class="text-primary">{{ $pacientes->count() }} registros</span>
                    </h6>
                    <a href="{{ route('pacientes.create') }}" class="btn btn-primary btn-sm fw-bold shadow-sm px-3 rounded-pill">
                        <i class="bi bi-person-plus-fill me-1"></i> Nuevo Paciente
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-custom table-clickable">
                        <thead>
                            <tr>
                                <th class="ps-4">Paciente</th>
                                <th>Documento</th>
                                <th>Contacto</th>
                                <th class="text-center">Registro</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pacientes as $paciente)
                                <tr onclick="window.location='{{ route('pacientes.show', $paciente->id) }}'">
                                    <td class="ps-4">
                                        <div class="fw-bold text-muted">{{ $paciente->apellido }}, {{ $paciente->nombre }}</div>
                                        <div class="text-muted small">
                                            {{ $paciente->edad }} años • {{ strtoupper(substr($paciente->sexo, 0, 1)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge text-secondary border fw-normal px-2 py-1">{{ $paciente->dni }}</span>
                                    </td>
                                    <td>
                                        <div class="small text-muted">
                                            <i class="bi bi-telephone text-success me-1"></i>{{ $paciente->telefono ?? '---' }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="small fw-medium text-dark">{{ $paciente->created_at->format('d/m/Y') }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $paciente->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="dropdown text-muted">
                                            <button class="btn btn-sm border rounded-pill px-3 dropdown-toggle fw-bold" 
                                                    type="button"
                                                    data-bs-toggle="dropdown" 
                                                    data-bs-boundary="viewport"
                                                    onclick="event.stopPropagation();">
                                                Acciones
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                                                <li><a class="dropdown-item py-2" href="{{ route('consulta.create', $paciente->id) }}" onclick="event.stopPropagation();"><i class="bi bi-plus-circle me-2 text-primary"></i>Nueva Consulta</a></li>
                                                <li><a class="dropdown-item py-2" href="{{ route('citas.create', ['paciente_id' => $paciente->id]) }}" onclick="event.stopPropagation();"><i class="bi bi-calendar-plus me-2 text-primary"></i>Agendar Cita</a></li>
                                                <li><a class="dropdown-item py-2" href="{{ route('consulta.historial', $paciente->id) }}" onclick="event.stopPropagation();"><i class="bi bi-file-earmark-medical me-2 text-primary"></i>Historial</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li>
                                                    <a class="dropdown-item py-2" href="javascript:void(0)" 
                                                       onclick="event.stopPropagation(); abrirModalDerivacion('{{ $paciente->id }}', '{{ $paciente->nombre }} {{ $paciente->apellido }}')">
                                                        <i class="bi bi-arrow-right-circle me-2 text-info"></i>Derivar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-2" href="javascript:void(0)" 
                                                       onclick="event.stopPropagation(); abrirModalDiagnostico('{{ $paciente->id }}', '{{ $paciente->apellido }} {{ $paciente->nombre }}', '{{ $paciente->dni }}')">
                                                        <i class="bi bi-clipboard-check me-2 text-success"></i>Diagnosticar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-search fs-2 d-block mb-2 opacity-25"></i>
                                        No se encontraron pacientes registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pacientes.partials.modales')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/js/pages/pacientes.js'])

    {{-- Pasamos el mensaje de sesión a una variable JS segura --}}
    <script>
        window.sessionSuccess = "{{ session('success') }}";
    </script>
@endpush
@endsection