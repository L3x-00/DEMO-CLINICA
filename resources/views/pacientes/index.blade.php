@extends('layouts.app')

{{-- Estilos específicos para esta vista --}}
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/clinica.css') }}">
@endpush

@section('content')
<div class="container mt-4 mb-5">
    {{-- ALERTAS --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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
<div class="card shadow border-0 overflow-hidden">
    {{-- Eliminamos bg-white para que herede el tema --}}
    <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">
            <i class="bi bi-person-lines-fill me-2 text-primary"></i> 
            <span class="text-body-secondary">Mostrando:</span> 
            <span class="text-primary">{{ $pacientes->count() }} registros</span>
        </h6>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary btn-sm fw-bold shadow-sm px-3">
            <i class="bi bi-person-plus-fill me-1"></i> Nuevo Paciente
        </a>
        
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-clickable table-custom">
            {{-- Cambiamos table-light por bg-body-tertiary (gris suave en luz, carbón en oscuro) --}}
            <thead class="bg-body-tertiary text-secondary small text-uppercase">
                <tr>
                    <th class="ps-4 py-3">Paciente</th>
                    <th>Documento</th>
                    <th>Contacto</th>
                    <th class="pe-4 text-end">Registro 📅</th>
                    <th class="pe-4 text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pacientes as $paciente)
                    <tr onclick="window.location='{{ route('pacientes.show', $paciente->id) }}'" style="cursor: pointer;">
                        <td class="ps-4">
                            <div class="fw-bold text-primary">{{ $paciente->apellido }}, {{ $paciente->nombre }}</div>
                            <div class="mt-1">
                                <span class="badge bg-body-secondary text-body-emphasis border-0 fw-normal">
                                    <i class="bi bi-gender-ambiguous me-1"></i>{{ $paciente->sexo == 'Masculino' ? 'M' : 'F' }} — {{ $paciente->edad }} años
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="small text-muted d-block">{{ $paciente->tipo_documento ?? 'DNI' }}</span>
                            <span class="fw-bold">{{ $paciente->dni }}</span>
                        </td>
                        <td>
                            <div class="small mb-1">
                                <i class="bi bi-telephone text-success me-1"></i>{{ $paciente->telefono ?? 'S/N' }}
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="small fw-bold">{{ $paciente->created_at->format('d/m/Y') }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-clock me-1"></i>{{ $paciente->created_at->format('h:i A') }}
                            </div>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex flex-column flex-md-row justify-content-end gap-2">
                                {{-- BOTÓN HISTORIAL (NUEVO) --}}
                                <a href="{{ route('consulta.historial', $paciente->id) }}" 
                                class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm"
                                onclick="event.stopPropagation();"
                                title="Ver historial de consultas">
                                    <i class="bi bi-clock-history me-1"></i> Historial
                                </a>
                                {{-- NUEVO BOTÓN: CONSULTA MÉDICA --}}
                                <a href="{{ route('consulta.create', $paciente->id) }}" 
                                class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm"
                                onclick="event.stopPropagation();"
                                title="Nueva Consulta Médica">
                                    <i class="bi bi-clipboard2-pulse-fill me-1"></i> Consulta
                                </a>

                                {{-- TU BOTÓN EXISTENTE: DIAGNÓSTICO --}}
                                <button type="button" 
                                    class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm"
                                    onclick="event.stopPropagation(); abrirModalDiagnostico('{{ $paciente->id }}', '{{ $paciente->apellido }} {{ $paciente->nombre }}', '{{ $paciente->dni }}')"
                                    title="Nuevo Registro Integral">
                                    <i class="bi bi-stethoscope me-1"></i> Diagnosticar
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                <tr>
                    {{-- Corregido el colspan a 5 porque tienes 5 columnas <th> --}}
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted opacity-50">
                            <i class="bi bi-clipboard2-x fs-1 d-block mb-2"></i>
                            <p class="mb-0">No se encontraron pacientes registrados.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINACIÓN ADAPTABLE --}}
    @if($pacientes instanceof \Illuminate\Pagination\LengthAwarePaginator && $pacientes->hasPages())
        {{-- Eliminamos bg-white --}}
        <div class="card-footer border-top-0 py-3 bg-transparent">
            {{ $pacientes->appends(request()->all())->links() }}
        </div>
    @endif
</div>
    </div>
</div>
{{-- MODAL DE DIAGNÓSTICO --}}
{{-- Modal de Registro Integral --}}
<div class="modal fade" id="modalDiagnostico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background-color: white !important; color: #333 !important; border-radius: 20px;">
            <div class="modal-header border-bottom border-light px-4">
                <h5 class="modal-title fw-bold text-primary"><i class="bi bi-plus-circle-fill me-2"></i>Nuevo Registro Integral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formDiagnostico" action="{{ route('caja.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="paciente_id" id="paciente_id_hidden" required>
                    
                    <div class="row">
                        {{-- Columna Izquierda: Médica --}}
                        <div class="col-md-6 border-end border-light">
                            <h6 class="fw-bold mb-3 text-uppercase small opacity-75 text-primary">Información Médica</h6>
                            
                            <div class="mb-3 p-3 rounded-3 bg-primary bg-opacity-10 border border-primary border-opacity-25">
                                <label class="form-label small fw-bold text-primary mb-0">PACIENTE</label>
                                <div id="nombrePacienteDisplay" class="fw-bold text-dark fs-5">-</div>
                                <div id="dniPacienteDisplay" class="text-muted small">DNI: -</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">📦 SERVICIO</label>
                                <select name="servicio" class="form-select rounded-3 border-secondary border-opacity-25" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Rayos X">Rayos X 🩻</option>
                                    <option value="Ecografía">Ecografía 🧬</option>
                                    <option value="Traumatología">Traumatología 🦴</option>
                                    <option value="Laboratorio">Laboratorio 🧪</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">📝 OBSERVACIONES</label>
                                <textarea name="observacion" class="form-control rounded-3 border-secondary border-opacity-25" rows="3" placeholder="Detalles clínicos..."></textarea>
                            </div>
                        </div>

                        {{-- Columna Derecha: Caja --}}
                        <div class="col-md-6 ps-md-4">
                            <h6 class="fw-bold mb-3 text-uppercase small opacity-75 text-success">Información de Caja</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-success">💰 COSTO (S/.)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success bg-opacity-10 border-success border-opacity-25">S/.</span>
                                    <input type="number" step="0.01" name="costo" class="form-control rounded-end-3 border-success border-opacity-25" placeholder="0.00" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-danger">💸 COMISIÓN (S/.)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger bg-opacity-10 border-danger border-opacity-25">S/.</span>
                                    <input type="number" step="0.01" name="comision" class="form-control rounded-end-3 border-danger border-opacity-25" placeholder="0.00" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-primary">👤 JALADORA / REFERIDO</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" name="jaladora" class="form-control rounded-end-3 border-secondary border-opacity-25" placeholder="Nombre...">
                                </div>
                            </div>

                            <div class="alert alert-warning py-2 border-0 small">
                                <i class="bi bi-info-circle me-1"></i> Este registro se enviará automáticamente al módulo de caja.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formDiagnostico" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">Guardar Registro</button>
            </div>
        </div>
    </div>
</div>
<script>
    function abrirModalDiagnostico(id, nombre, dni) {
        // 1. Asignar ID al campo oculto
        document.getElementById('paciente_id_hidden').value = id;
        
        // 2. Mostrar datos visuales del paciente en el modal
        document.getElementById('nombrePacienteDisplay').innerText = nombre;
        document.getElementById('dniPacienteDisplay').innerText = 'DNI: ' + dni;
        
        // 3. Limpiar formulario por si se usó antes
        document.getElementById('formDiagnostico').reset();
        // El reset borra el hidden, lo reasignamos
        document.getElementById('paciente_id_hidden').value = id;

        // 4. Abrir Modal
        const modal = new bootstrap.Modal(document.getElementById('modalDiagnostico'));
        modal.show();
    }
</script>

@endsection