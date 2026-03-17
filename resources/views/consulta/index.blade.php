@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark"><i class="bi bi-journal-medical text-primary me-2"></i>Historial Clínico</h2>
            <p class="text-muted">Paciente: <strong>{{ $paciente->apellido }}, {{ $paciente->nombre }}</strong></p>
        </div>
        <a href="{{ route('consulta.create', $paciente->id) }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> Nueva Consulta
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">N°</th>
                        <th>Fecha y Hora</th>
                        <th>Motivo</th>
                        <th>Diagnóstico</th>
                        <th>Atendido por</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas as $con)
                    <tr>
                        <td class="ps-4 fw-bold">#{{ $con->numero_consulta }}</td>
                        <td>
                            <div class="small fw-bold">{{ \Carbon\Carbon::parse($con->fecha_registro)->format('d/m/Y') }}</div>
                            <div class="text-muted small">{{ $con->hora_registro }}</div>
                        </td>
                        <td class="small">{{ Str::limit($con->motivo_consulta, 40) }}</td>
                        <td><span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ Str::limit($con->diagnostico, 30) }}</span></td>
                        <td class="small">{{ $con->atendido_por }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('consulta.show', $con->id) }}" class="btn btn-sm btn-light border" title="Ver Detalle">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('consulta.edit', $con->id) }}" class="btn btn-sm btn-light border text-warning" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No hay consultas registradas para este paciente.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('pacientes.index') }}" class="btn btn-link text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Volver a Pacientes
        </a>
    </div>
</div>
@endsection