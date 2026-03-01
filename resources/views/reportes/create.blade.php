@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="row">
        {{-- COLUMNA IZQUIERDA: DATOS DEL PACIENTE (Autocompletados) --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-person-badge me-2"></i> Información del Paciente
                </div>
                <div class="card-body">
                    @if($paciente)
                        {{-- Caso 1: Viene desde el historial del paciente --}}
                        <div class="mb-3 text-center">
                            @if($paciente->evidencia)
                                <img src="{{ asset('storage/' . $paciente->evidencia) }}" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 100px; height: 100px;">
                                    <i class="bi bi-person text-secondary fs-1"></i>
                                </div>
                            @endif
                            <h5 class="fw-bold mt-2">{{ $paciente->nombre }} {{ $paciente->apellido }}</h5>
                        </div>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item d-flex justify-content-between"><strong>DNI:</strong> {{ $paciente->dni }}</li>
                            <li class="list-group-item d-flex justify-content-between"><strong>Edad:</strong> 
                                {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años
                            </li>
                            <li class="list-group-item d-flex justify-content-between"><strong>Sexo:</strong> {{ $paciente->sexo }}</li>
                            <li class="list-group-item text-danger"><strong>Alergias:</strong> {{ $paciente->alergias ?? 'Ninguna' }}</li>
                        </ul>
                        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}" form="formReporte">
                    @else
                        {{-- Caso 2: Se genera desde la ventana de Reportes (Buscador) --}}
                        <div class="alert alert-info small">
                            <i class="bi bi-info-circle me-1"></i> Seleccione un paciente para comenzar el informe.
                        </div>
                        <label class="form-label fw-bold small">Buscar Paciente</label>
                        <select class="form-select" id="select-paciente" name="paciente_id" form="formReporte" required>
                            <option value="">Seleccione...</option>
                            @foreach($pacientes as $p)
                                <option value="{{ $p->id }}">{{ $p->dni }} - {{ $p->nombre }} {{ $p->apellido }}</option>
                            @endforeach
                        </select>
                    @endif

                    <hr>
                    <div class="small">
                        <p class="mb-1 text-muted"><strong>Doctor:</strong> {{ Auth::user()->name }}</p>
                        <p class="mb-0 text-muted"><strong>Fecha:</strong> {{ date('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: FORMULARIO DEL INFORME MÉDICO --}}
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 fw-bold text-dark">Nuevo Informe Médico 📝</h4>
                </div>
                <div class="card-body bg-light">
                    <form action="{{ route('reportes.store') }}" method="POST" id="formReporte">
                        @csrf
                        
                        {{-- Si no hay paciente preseleccionado, el ID viene del select de la izquierda --}}
                        <div class="col-md-12">
                            <label class="form-label fw-bold ">Resumen de Historia Clínica</label>
                            <textarea name="resumen_historia" class="form-control" rows="2" readonly 
                                    style="border: 1px solid #f5c2c7;">{{ $paciente ?  ($paciente->alergias ?? 'Ninguna') : 'Seleccione un paciente para ver sus antecedentes.' }}</textarea>
                            <small class="text-muted">Este campo se extrae automáticamente del perfil del paciente.</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Examen Físico Preferencial</label>
                                <textarea name="examen_fisico_preferencial" class="form-control" rows="2" placeholder="Describa el examen físico..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Examen Auxiliar</label>
                                <textarea name="examen_auxiliar" class="form-control" rows="2" placeholder="Laboratorios, Rayos X, etc."></textarea>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-bold text-primary">Diagnóstico</label>
                                <input type="text" name="diagnostico" class="form-control" required placeholder="Diagnóstico principal">
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">CIE-10</label>
                                <input type="text" name="cie_10" class="form-control" placeholder="Eje: M54.5">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Tratamiento</label>
                                <textarea name="tratamiento" class="form-control" rows="3" placeholder="Medicamentos y dosis..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Evolución</label>
                                <textarea name="evolucion" class="form-control" rows="2" placeholder="Evolución clínica del paciente..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Recomendaciones</label>
                                <textarea name="recomendaciones" class="form-control" rows="2" placeholder="Indicaciones adicionales..."></textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Guardar Informe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script para TomSelect si no hay paciente --}}
@if(!$paciente)
<script>
    new TomSelect("#select-paciente",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
</script>
@endif
@endsection