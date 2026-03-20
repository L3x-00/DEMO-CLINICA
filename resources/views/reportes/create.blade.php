@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="row g-4">
        {{-- COLUMNA IZQUIERDA: RESUMEN PACIENTE --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px; border-radius: 15px; background-color: var(--card-bg);">
                <div class="card-header bg-primary text-white fw-bold py-3" style="border-radius: 15px 15px 0 0;">
                    <i class="bi bi-person-badge me-2"></i> Datos del Paciente
                </div>
                <div class="card-body">
                    @if($paciente)
                        <div class="text-center mb-4">
                            @if($paciente->evidencia)
                                <img src="{{ asset('storage/' . $paciente->evidencia) }}" class="rounded-circle border shadow-sm mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                    <i class="bi bi-person-fill fs-1"></i>
                                </div>
                            @endif
                            <h5 class="fw-bold mb-0">{{ $paciente->nombre }} {{ $paciente->apellido }}</h5>
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill">ID: #{{ $paciente->id }}</span>
                        </div>
                        
                        <div class="p-3 rounded-3 bg-body-tertiary mb-3">
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="opacity-75 text-body-color">DNI:</span>
                                <span class="fw-bold text-body-color">{{ $paciente->dni }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="opacity-75 text-body-color">Edad:</span>
                                <span class="fw-bold text-body-color">{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="opacity-75 text-body-color">Sexo:</span>
                                <span class="fw-bold text-body-color">{{ $paciente->sexo }}</span>
                            </div>
                        </div>

                        <div class="alert alert-danger border-0 py-2 small mb-0">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Alergias:</strong> {{ $paciente->alergias ?? 'Ninguna' }}
                        </div>
                        
                        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}" form="formReporte">
                    @else
                        <div class="mb-4">
                            <label class="form-label fw-bold small opacity-75">BUSCAR EXPEDIENTE</label>
                            <select class="form-select" id="select-paciente" name="paciente_id" form="formReporte" required>
                                <option value="">Escribe nombre o DNI...</option>
                                @foreach($pacientes as $p)
                                    <option value="{{ $p->id }}" data-alergias="{{ $p->alergias ?? 'Ninguna conocida' }}">
                                        {{ $p->dni }} | {{ $p->apellido }}, {{ $p->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <hr class="my-4 opacity-25">
                    
                    <div class="d-flex align-items-center gap-3 px-2">
                        <div class="flex-shrink-0">
                            <i class="bi bi-person-workspace fs-3 text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0 small fw-bold text-body-color">{{ Auth::user()->name }}</p>
                            <p class="mb-0 x-small opacity-50 text-body-color">{{ date('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: FORMULARIO --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 15px; background-color: var(--card-bg);">
                <div class="card-header py-4 px-4 bg-transparent border-bottom border-secondary border-opacity-10">
                    <h4 class="mb-0 fw-bold" style="color: var(--accent-main);">
                        <i class="bi bi-file-earmark-medical me-2"></i>Nuevo Informe Médico
                    </h4>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('reportes.store') }}" method="POST" id="formReporte">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold opacity-75 small">RESUMEN HISTORIA / ALERGIAS</label>
                            <textarea name="resumen_historia" class="form-control border-0 bg-body-tertiary" rows="2" readonly 
                                    style="border-left: 4px solid var(--accent-main) !important;">{{ $paciente ? ($paciente->alergias ?? 'Ninguna') : 'Seleccione un paciente...' }}</textarea>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small opacity-75">EXAMEN FÍSICO PREFERENCIAL</label>
                                <textarea name="examen_fisico_preferencial" class="form-control custom-input" rows="2" placeholder="Describa hallazgos físicos..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small opacity-75">EXAMEN AUXILIAR</label>
                                <textarea name="examen_auxiliar" class="form-control custom-input" rows="2" placeholder="Laboratorios, Rayos X, otros."></textarea>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-bold small opacity-75" style="color: var(--accent-main);">DIAGNÓSTICO PRINCIPAL</label>
                                <input type="text" name="diagnostico" id="diagnostico" 
                                    class="form-control custom-input fw-bold text-primary shadow-sm" 
                                    required placeholder="Escriba el diagnóstico">
                                <div class="invalid-feedback">El diagnóstico es obligatorio.</div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-bold small opacity-75">CIE-10</label>
                                <input type="text" name="cie_10" id="cie_10" 
                                    class="form-control custom-input" 
                                    placeholder="Ej: M54.5"
                                    maxlength="10">
                                <div class="invalid-feedback">Formato CIE-10 no válido (Ej: A00.0).</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small opacity-75">TRATAMIENTO Y PRESCRIPCIÓN</label>
                                <textarea name="tratamiento" class="form-control custom-input" rows="4" 
                                        placeholder="Indicar medicamentos, dosis y frecuencia..." required></textarea>
                                <div class="invalid-feedback">Debe indicar el tratamiento para el paciente.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small opacity-75">EVOLUCIÓN CLÍNICA</label>
                                <textarea name="evolucion" class="form-control custom-input" rows="2"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small opacity-75">RECOMENDACIONES</label>
                                <textarea name="recomendaciones" class="form-control custom-input" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between align-items-center">
                            <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none text-muted fw-bold">
                                <i class="bi bi-arrow-left"></i> Regresar
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">
                                <i class="bi bi-save2 me-2"></i>Guardar Informe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection