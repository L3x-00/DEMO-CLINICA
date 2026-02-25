@extends('layouts.app')

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Estilo para que la fila parezca interactiva */
    .table-clickable tbody tr { 
        cursor: pointer; 
        transition: all 0.2s ease;
    }
    /* Efecto de resaltado al pasar el mouse */
    .table-clickable tbody tr:hover { 
        background-color: rgba(13, 110, 253, 0.05) !important;
        transform: scale(1.002);
    }
</style>
@endpush

@section('content')
<div class="container mt-4 mb-5">

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="col-lg-12">
        {{-- CABECERA Y FILTROS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="mb-0 fw-bold text-primary">Pacientes</h4>
                        <p class="text-muted small mb-0">Seleccione un paciente para ver su historial</p>
                    </div>
                    
                    <div class="col-md-8">
                        <form action="{{ route('pacientes.index') }}" method="GET" class="row g-2 justify-content-end">
                            {{-- Filtro Fecha --}}
                            <div class="col-auto">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light text-primary border-primary">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>
                                    <input type="date" name="fecha" class="form-control border-primary" 
                                           value="{{ $fechaBusqueda }}" onchange="this.form.submit()">
                                </div>
                            </div>
                            {{-- Buscador Texto --}}
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="buscar" class="form-control border-primary" 
                                           placeholder="DNI o Apellido..." value="{{ request('buscar') }}">
                                    <button type="submit" class="btn btn-primary px-3">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    @if(request('buscar') || request('fecha'))
                                        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-danger" title="Limpiar">
                                            <i class="bi bi-x-lg"></i>
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
        <div class="card shadow border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-secondary">
                    <i class="bi bi-person-lines-fill me-2"></i> Mostrando: 
                    <span class="text-primary">{{ $pacientes->count() }} registros</span>
                </h6>
                <a href="{{ route('pacientes.create') }}" class="btn btn-primary btn-sm fw-bold shadow-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Nuevo Paciente
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-clickable">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4">Paciente</th>
                            <th>Documento</th>
                            <th>Contacto</th>
                            <th class="pe-4">Registro 📅</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pacientes as $paciente)
                        {{-- La fila entera redirige al Show --}}
                        <tr onclick="window.location='{{ route('pacientes.show', $paciente->id) }}'">
                            {{-- PACIENTE Y DATOS BIO --}}
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $paciente->apellido }}, {{ $paciente->nombre }}</div>
                                <div class="text-muted small">
                                    <span class="badge bg-light text-dark border-0 fw-normal">
                                        {{ $paciente->sexo == 'Masculino' ? 'M' : 'F' }} — {{ $paciente->edad }} años
                                    </span>
                                </div>
                            </td>

                            {{-- DOCUMENTO --}}
                            <td>
                                <span class="small text-muted d-block">{{ $paciente->tipo_documento ?? 'DNI' }}</span>
                                <span class="fw-bold text-secondary">{{ $paciente->dni }}</span>
                            </td>

                            {{-- CONTACTO --}}
                            <td>
                                <div class="small"><i class="bi bi-telephone text-success me-1"></i>{{ $paciente->telefono ?? 'S/N' }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 180px;">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $paciente->provincia ?? '---' }} - {{ $paciente->distrito ?? '---' }}
                                </div>
                            </td>

                            {{-- FECHA DE REGISTRO --}}
                            <td class="pe-4">
                                <div class="small fw-bold">{{ $paciente->created_at->format('d/m/Y') }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-clock me-1"></i>{{ $paciente->created_at->format('h:i A') }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted opacity-50">
                                    <i class="bi bi-clipboard2-x fs-1 d-block mb-2"></i>
                                    <p>No se encontraron pacientes registrados.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            @if($pacientes instanceof \Illuminate\Pagination\LengthAwarePaginator && $pacientes->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $pacientes->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection