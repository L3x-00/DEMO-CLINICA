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

        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-primary border-4">
                <div class="card-header fw-bold text-primary">1. Información del Paciente (Automático)</div>
                <div class="card-body row ">
                    <div class="col-md-3">
                        <label class="form-label">Paciente</label>
                        <input type="text" class="form-control" value="{{ $paciente->nombre }} {{ $paciente->apellido }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Doc. de Identidad</label>
                        <input type="text" name="DNI" class="form-control" value="{{ $paciente->dni}}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha_registro" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Hora</label>
                        <input type="time" name="hora_registro" class="form-control" value="{{ date('H:i') }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Edad</label>
                        <input type="text" name="edad_momento" class="form-control" value="{{ $paciente->edad }} años" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-primary border-4">
                <div class="card-header fw-bold text-primary">2. Anamnesis y Funciones Biológicas</div>
                <div class="card-body row g-3">
                    <div class="col-8">
                        <label class="form-label">Motivo de consulta</label>
                        <textarea type="text" name="motivo_consulta" class="form-control" rows="1" placeholder="Describa el motivo..."></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tiempo de enfermedad</label>
                        <input type="string" name="tiempo_enfermedad" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Apetito</label>
                        <input type="string" name="apetito" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sed</label>
                        <input type="string" name="sed" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sueño</label>
                        <input type="string" name="sueno" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado de ánimo</label>
                        <input type="string" name="estado_animo" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-primary border-4">
                <div class="card-header  fw-bold text-primary">3. Deposiciones</div>
                <div class="card-body row g-2">
                    <div class="col-6">
                        <label class="form-label">Temperatura (°C)</label>
                        <input type="string" name="temperatura" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label">P. Arterial</label>
                        <input type="string" name="presion_arterial" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label">F. Respiratoria</label>
                        <input type="string" name="frecuencia_respiratoria" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label">F. Cardiaca</label>
                        <input type="string" name="frecuencia_cardiaca" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Peso (kg)</label>
                        <input type="string" name="peso" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Talla(cm)</label>
                        <input type="string" name="talla" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Orina</label>
                        <input type="string" name="orina" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Deposiciones</label>
                        <input type="string" name="deposiciones" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Examen Físico General</label>
                        <textarea type="text" name="examen_fisico" class="form-control form-control-sm" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-primary border-4">
                <div class="card-header fw-bold text-primary">4. Diagnóstico y Tratamiento</div>
                <div class="card-body row g-3">
                    <div class="col-7">
                        <label class="form-label">Diagnóstico</label>
                        <textarea type="text" name="diagnostico" class="form-control" rows="2" placeholder="Describa el diagnóstico..."></textarea>
                    </div>
                    <div class="col-5">
                        <label class="form-label">Tratamiento</label>
                        <textarea type="text" name="tratamiento" class="form-control" rows="2" placeholder="Describa el tratamiento..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-primary border-4">
                <div class="card-header  fw-bold text-primary">5. Examenes Auxiliares</div>
                <div class="card-body row g-2">
                    <div class="col-6">
                        <label class="form-label">Ex. Auxiliares</label>
                        <input type="text" name="examenes_auxiliares" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Referencia (lugar y motivo)</label>
                        <input type="text" name="referencia_lugar_motivo" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Próxima cita</label>
                        <input type="date" name="proxima_cita" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-primary bg-opacity-10 border-start border-primary border-4">
                <div class="card-body row">
                    <div class="col-md-4">
                        <label class="small text-muted">Atendido por:</label>
                        <input type="text" name="atendido_por" class="form-control-plaintext fw-bold" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted">Firma y sello</label>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
        

        <div class="col-12 text-end mb-5">
            <hr>
            <button type="reset" class="btn btn-outline-danger border-2 px-4 me-2">Limpiar</button>
            <button type="submit" class="btn btn-primary px-5 shadow">Guardar Consulta Médica</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pages/consulta.js') }}"></script>
@endpush