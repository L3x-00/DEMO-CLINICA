@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-calendar2-check me-2"></i>Detalle de la Cita</h5>
                    <a href="{{ route('citas.index') }}" class="btn btn-sm btn-light">Volver</a>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Paciente</label>
                            <span class="fs-5 fw-bold text-primary">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</span>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <label class="text-muted small d-block">Estado Actual</label>
                            <span class="badge rounded-pill {{ $cita->estado == 'Pendiente' ? 'bg-warning text-dark' : ($cita->estado == 'Concluido' ? 'bg-success' : 'bg-danger') }}">
                                {{ $cita->estado }}
                            </span>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small d-block"><i class="bi bi-calendar-event"></i> Fecha</label>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small d-block"><i class="bi bi-clock"></i> Hora</label>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <label class="text-muted small d-block"><i class="bi bi-card-text"></i> DNI</label>
                                <span class="fw-bold">{{ $cita->paciente->dni }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small d-block fw-bold mb-2">Motivo de la Consulta</label>
                        <div class="p-3 border rounded bg-white">
                            {{ $cita->motivo ?? 'Sin motivo especificado.' }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-warning px-4">
                            <i class="bi bi-pencil-square"></i> Editar Cita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection