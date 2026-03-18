@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Consulta N° {{ $consulta->numero_consulta }}</h2>
        <a href="{{ route('pacientes.index') }}" class="btn btn-light border shadow-sm">Cancelar</a>
    </div>

    <form action="{{ route('consulta.update', $consulta->id) }}" method="POST" id="formEditConsulta">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 bg-light">
                    <div class="card-body py-2 px-4 d-flex gap-4">
                        <p class="mb-0"><strong>Paciente:</strong> {{ $consulta->paciente->nombre }} {{ $consulta->paciente->apellido }}</p>
                        <p class="mb-0"><strong>Fecha original:</strong> {{ $consulta->fecha_registro }}</p>
                        <p class="mb-0"><strong>Edad en consulta:</strong> {{ $consulta->edad_momento }} años</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header  fw-bold">Actualizar Anamnesis</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Motivo de consulta</label>
                            <textarea name="motivo_consulta" class="form-control" rows="3">{{ $consulta->motivo_consulta }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tiempo de enfermedad</label>
                                <input type="text" name="tiempo_enfermedad" class="form-control" value="{{ $consulta->tiempo_enfermedad }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado de ánimo</label>
                                <input type="text" name="estado_animo" class="form-control" value="{{ $consulta->estado_animo }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tratamiento Actualizado</label>
                            <textarea name="tratamiento" class="form-control" rows="5" style="border-left: 4px solid #0d6efd;">{{ $consulta->tratamiento }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header  fw-bold">Actualizar Signos Vitales</div>
                    <div class="card-body">
                        @php $vitales = ['temperatura', 'presion_arterial', 'frecuencia_cardiaca', 'frecuencia_respiratoria', 'peso', 'talla']; @endphp
                        @foreach($vitales as $v)
                        <div class="mb-3">
                            <label class="form-label small text-uppercase text-muted">{{ str_replace('_', ' ', $v) }}</label>
                            <input type="text" name="{{ $v }}" class="form-control" value="{{ $consulta->$v }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 text-end mb-5">
                <button type="submit" class="btn btn-warning px-5 fw-bold shadow">Guardar Cambios</button>
            </div>
        </div>
    </form>
</div>
@endsection