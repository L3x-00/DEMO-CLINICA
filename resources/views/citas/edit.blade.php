@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-warning py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar/Reprogramar Cita</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('citas.update', $cita->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Paciente</label>
                            <input type="text" class="form-control bg-light" value="{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}" readonly>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nueva Fecha</label>
                                <input type="date" name="fecha" class="form-control border-warning" value="{{ $cita->fecha }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nueva Hora</label>
                                <input type="time" name="hora" class="form-control border-warning" value="{{ $cita->hora }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Estado</label>
                            <select name="estado" class="form-select border-warning">
                                <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Concluido" {{ $cita->estado == 'Concluido' ? 'selected' : '' }}>Concluido</option>
                                <option value="No presentado" {{ $cita->estado == 'No presentado' ? 'selected' : '' }}>No presentado</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Motivo</label>
                            <textarea name="motivo" class="form-control border-warning" rows="3">{{ $cita->motivo }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning px-4 fw-bold">Actualizar Cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection