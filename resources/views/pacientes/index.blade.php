@extends('layouts.app')

{{-- Estilos para iconos y ajustes visuales --}}
@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@section('content')
<div class="container mt-4 mb-5">

    {{-- Alerta de éxito al guardar/editar/eliminar --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="col-lg-12">
        
        {{-- CABECERA: Título y Filtros Unificados --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="mb-0 fw-bold text-secondary">Pacientes Registrados</h4>
                        <p class="text-muted small mb-0">Gestión diaria de historias clínicas</p>
                    </div>
                    
                    {{-- Formulario Único: Combina búsqueda por texto y fecha --}}
                    <div class="col-md-8">
                        <form action="{{ route('pacientes.index') }}" method="GET" class="row g-2 justify-content-end">
                            
                            {{-- Filtro de Fecha: Limpia la vista por día --}}
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-primary text-white border-primary">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>
                                    <input type="date" name="fecha" class="form-control border-primary" 
                                           value="{{ $fechaBusqueda }}" 
                                           onchange="this.form.submit()" title="Filtrar por día de registro">
                                    <a href="{{ route('pacientes.index') }}" class="btn btn-outline-primary" title="Ver hoy">Hoy</a>
                                </div>
                            </div>

                            {{-- Buscador por Texto: DNI o Nombre --}}
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="buscar" class="form-control border-primary" 
                                           placeholder="Buscar por DNI o Apellido..." 
                                           value="{{ request('buscar') }}">
                                    <button type="submit" class="btn btn-primary px-3">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    @if(request('buscar') || request('fecha') != date('Y-m-d'))
                                        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-danger" title="Limpiar filtros">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Indicador de filtro actual --}}
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <span class="badge bg-info text-dark p-2 shadow-sm">
                <i class="bi bi-funnel-fill me-1"></i> 
                Mostrando: {{ \Carbon\Carbon::parse($fechaBusqueda)->isToday() ? 'Hoy' : \Carbon\Carbon::parse($fechaBusqueda)->format('d/m/Y') }}
            </span>
            <span class="text-muted small">Total encontrados: {{ $pacientes->count() }}</span>
        </div>

        {{-- TABLA DE RESULTADOS --}}
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i> Listado de Atención</h5>
                <a href="{{ route('pacientes.create') }}" class="btn btn-light fw-bold text-primary shadow-sm btn-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Nuevo Paciente
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 bg-white">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">Documento</th>
                            <th>Paciente / Datos Biológicos</th>
                            <th>Ubicación</th>
                            <th>Contacto</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pacientes as $paciente)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark border mb-1 d-block w-fit">{{ $paciente->tipo_documento ?? 'DNI' }}</span>
                                    <span class="fw-bold">{{ $paciente->dni }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $paciente->apellido }}, {{ $paciente->nombre }}</div>
                                    <small class="text-muted">
                                        <i class="bi bi-gender-ambiguous"></i> {{ $paciente->sexo }} | 
                                        <i class="bi bi-calendar3"></i> {{ $paciente->edad }} años
                                    </small>
                                </td>
                                <td>
                                    <div class="small fw-bold">{{ $paciente->distrito ?? '---' }}</div>
                                    <div class="small text-muted text-uppercase">{{ $paciente->provincia ?? '---' }}</div>
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-telephone-fill text-success small"></i> {{ $paciente->telefono ?? '---' }}</div>
                                    <div class="small text-muted"><i class="bi bi-envelope-at small"></i> {{ Str::limit($paciente->email, 20) ?? '---' }}</div>
                                </td>
                                <td class="text-center">
                                    {{-- Grupo de botones de acción estilizados --}}
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('pacientes.show', $paciente->id) }}" class="btn btn-info text-white" title="Ver Historia Clínica">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-warning" title="Editar Información">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        {{-- Botón eliminar con confirmación nativa --}}
                                        <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta historia clínica?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-clipboard2-x fs-1 d-block mb-3"></i>
                                        <p class="mb-0">No hay pacientes registrados para la fecha o criterio seleccionado.</p>
                                        <small>Intente cambiar la fecha o limpiar los filtros.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación manteniendo los filtros activos en la URL --}}
            @if($pacientes instanceof \Illuminate\Pagination\LengthAwarePaginator && $pacientes->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $pacientes->appends(request()->all())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection