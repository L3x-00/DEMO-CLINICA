@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0"><i class="bi bi-clipboard2-pulse me-2"></i>Nueva Consulta Médica</h2>
        <span class="badge bg-primary px-3 py-2">Consulta N° {{ $nuevoNumero }}</span>
    </div>

    <form action="{{ route('consulta.store') }}" method="POST" id="formConsulta" class="row g-3">
        @csrf
        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
        <input type="hidden" name="numero_consulta" value="{{ $nuevoNumero }}">

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-light fw-bold">1. Información del Paciente (Automático)</div>
                <div class="card-body row">
                    <div class="col-md-3">
                        <label class="small text-muted">Paciente</label>
                        <input type="text" class="form-control bg-light" value="{{ $paciente->nombre }} {{ $paciente->apellido }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted">Fecha</label>
                        <input type="date" name="fecha_registro" class="form-control bg-light" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted">Hora</label>
                        <input type="time" name="hora_registro" class="form-control bg-light" value="{{ date('H:i') }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted">Edad</label>
                        <input type="text" name="edad_momento" class="form-control bg-light" value="{{ $paciente->edad }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white fw-bold text-secondary">2. Anamnesis y Funciones Biológicas</div>
                <div class="card-body row g-3">
                    <div class="col-12">
                        <label class="form-label">Motivo de consulta</label>
                        <textarea name="motivo_consulta" class="form-control" rows="2" placeholder="Describa el motivo..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tiempo de enfermedad</label>
                        <input type="text" name="tiempo_enfermedad" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Apetito</label>
                        <select name="apetito" class="form-select">
                            <option value="Normal">Normal</option>
                            <option value="Aumentado">Aumentado</option>
                            <option value="Disminuido">Disminuido</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sed</label>
                        <select name="sed" class="form-select"><option>Normal</option><option>Aumentado</option><option>Disminuido</option></select>
                    </div>
                    </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-primary border-4">
                <div class="card-header bg-white fw-bold text-primary">3. Examen Físico / Funciones Vitales</div>
                <div class="card-body row g-2">
                    <div class="col-6">
                        <label class="small fw-bold">Temperatura (°C)</label>
                        <input type="text" name="temperatura" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">P. Arterial</label>
                        <input type="text" name="presion_arterial" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">F. Cardiaca</label>
                        <input type="text" name="frecuencia_cardiaca" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">Peso (kg)</label>
                        <input type="text" name="peso" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="small fw-bold">Examen Físico General</label>
                        <textarea name="examen_fisico" class="form-control form-control-sm" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-primary bg-opacity-10">
                <div class="card-body row">
                    <div class="col-md-4">
                        <label class="small text-muted">Atendido por:</label>
                        <input type="text" name="atendido_por" class="form-control-plaintext fw-bold" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted">Nombres del Doctor:</label>
                        <input type="text" name="doctor_nombres" class="form-control-plaintext fw-bold" value="{{ $user->first_name }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted">Apellidos del Doctor:</label>
                        <input type="text" name="doctor_apellidos" class="form-control-plaintext fw-bold" value="{{ $user->last_name }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-end mb-5">
            <hr>
            <button type="reset" class="btn btn-light px-4 me-2">Limpiar</button>
            <button type="submit" class="btn btn-primary px-5 shadow">Guardar Consulta Médica</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pages/consulta.js') }}"></script>
@endpush