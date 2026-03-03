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
                    <div class="card border-0 bg-body-tertiary mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2">
                                    <i class="bi bi-search"></i>
                                </div>
                                <label class="form-label fw-bold mb-0">Localizar Expediente</label>
                            </div>
                            
                            <select class="form-select shadow-sm" id="select-paciente" name="paciente_id" form="formReporte" required>
                                <option value="">Seleccione un paciente de la lista...</option>
                                @foreach($pacientes as $p)
                                    <option value="{{ $p->id }}" data-alergias="{{ $p->alergias ?? 'Ninguna conocida' }}">
                                        {{ $p->dni }} | {{ $p->apellido }}, {{ $p->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <div class="form-text small opacity-75 mt-2">
                                <i class="bi bi-info-circle"></i> Los datos críticos (alergias) se cargarán automáticamente al seleccionar.
                            </div>
                        </div>
                    </div>
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
            <div class="card shadow border-0 overflow-hidden">
                {{-- Quitamos bg-white y text-dark, usamos clases neutras --}}
                
                <div class="card-header py-3" style="background-color: var(--card-bg); border-bottom: 1px solid var(--bs-border-color);">
                    <h4 class="mb-0 fw-bold" style="color: var(--accent-main);">Nuevo Informe Médico 📝</h4>
                </div>
                
                {{-- Quitamos bg-light para que use el color de la variable --}}
                <div class="card-body">
                    <form action="{{ route('reportes.store') }}" method="POST" id="formReporte">
                        @csrf
                        
                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-bold">Resumen de Historia Clínica (Alergias)</label>
                            {{-- Cambiamos el border inline por una variable o clase --}}
                            <textarea name="resumen_historia" class="form-control" rows="2" readonly 
                                    style="background-color: var(--nav-active-bg); border: 1px solid var(--accent-main); color: var(--nav-active-text);">{{ $paciente ? ($paciente->alergias ?? 'Ninguna') : 'Seleccione un paciente para ver sus antecedentes.' }}</textarea>
                            <small class="opacity-75">Este campo se extrae automáticamente del perfil del paciente.</small>
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
                                <label class="form-label fw-bold" style="color: var(--accent-main);">Diagnóstico Principal</label>
                                <input type="text" name="diagnostico" class="form-control" required placeholder="Diagnóstico principal">
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-bold" style="color: var(--accent-main);">CIE-10</label>
                                <input type="text" name="cie_10" class="form-control" placeholder="Ej: M54.5">
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
                            <a href="{{ url()->previous() }}" class="btn btn-light px-4 border">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPaciente = document.getElementById('select-paciente');
    // Asegúrate de que el ID sea 'resumen_historia', que es el campo que quieres llenar
    const campoResumen = document.querySelector('textarea[name="resumen_historia"]'); 

    if (selectPaciente) {
        selectPaciente.addEventListener('change', function() {
            // Obtenemos la opción seleccionada
            const selectedOption = this.options[this.selectedIndex];
            
            // Extraemos el dato del atributo data que creamos arriba
            const alergias = selectedOption.getAttribute('data-alergias');

            if (alergias) {
                // Rellenamos el campo con un formato profesional
                campoResumen.value = alergias;
                // Efecto visual opcional para que el médico note el cambio
                campoResumen.style.borderColor = "var(--accent-main)";
                setTimeout(() => campoResumen.style.borderColor = "", 1000);
            }
        });
    }
});
</script>
@endif
@endsection