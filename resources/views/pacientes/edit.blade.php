@extends('layouts.app')

@section('content')
<div class="container pb-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-warning text-dark py-3">
            <h3 class="mb-0 text-center">✏️ Editar Expediente: {{ $paciente->nombre }} {{ $paciente->apellido }}</h3>
        </div>
        <div class="card-body p-4">
            {{-- CORRECCIÓN: Un solo formulario, método PATCH/PUT y ENCTYPE para la imagen --}}
            <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h5 class="text-primary border-bottom pb-2 mb-3">1. Datos de Identificación</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold opacity-75">TIPO DE DOC.</label>
                        <select name="tipo_documento" 
                                id="tipo_documento" 
                                class="form-select border-0 shadow-sm custom-input" 
                                style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" 
                                required>
                            <option value="DNI" {{ (isset($paciente) && $paciente->tipo_documento == 'DNI') ? 'selected' : '' }}>DNI (Nacional)</option>
                            <option value="CUI" {{ (isset($paciente) && $paciente->tipo_documento == 'CUI') ? 'selected' : '' }}>CUI (Extranjero)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold opacity-75">N° DOCUMENTO</label>
                        <input type="text" 
                            name="dni" 
                            id="dni" 
                            class="form-control border-0 shadow-sm custom-input" 
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" 
                            placeholder="Ingrese el número" 
                            required 
                            value="{{ $paciente->dni ?? '' }}">
                        <div class="invalid-feedback" id="dni-error-msg">
                            Número de documento no válido.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sexo</label>
                        <select name="sexo" class="form-select border-primary" required>
                            <option value="Masculino" {{ $paciente->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ $paciente->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombres</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $paciente->nombre }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Apellidos</label>
                        <input type="text" name="apellido" class="form-control" value="{{ $paciente->apellido }}" required>
                    </div>
                </div>

                <h5 class="text-primary border-bottom pb-2 mb-3">2. Nacimiento </h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold opacity-75">FECHA DE NACIMIENTO</label>
                            <input type="date" 
                                name="fecha_nacimiento" 
                                id="fecha_nacimiento" 
                                class="form-control border-0 shadow-sm custom-input" 
                                style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" 
                                required 
                                value="{{ $paciente->fecha_nacimiento ?? '' }}">
                            <div class="invalid-feedback">
                                La fecha no puede ser futura ni estar vacía.
                            </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Edad</label>
                        <input type="text" name="edad" id="edad" class="form-control bg-light" value="{{ $paciente->edad }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nacionalidad</label>
                        <input type="text" name="nacionalidad" class="form-control" value="{{ $paciente->nacionalidad }}">
                    </div>
                </div>

                <h5 class="text-primary border-bottom pb-2 mb-3">3.Contacto</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ $paciente->telefono }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-danger">⚠️ Alergias y Advertencias Médicas</label>
                    <textarea name="alergias" class="form-control border-danger" rows="3">{{ $paciente->alergias }}</textarea>
                </div>
                <div class="row mb-5">
                    <div class="col-12">
                        <label class="form-label fw-bold"><i class="bi bi-camera me-2 text-primary"></i>Actualizar Evidencia (Imagen)</label>
                        @if($paciente->evidencia)
                            <div class="mb-2">
                                <small class="text-muted">Imagen actual:</small><br>
                                <img src="{{ asset('storage/' . $paciente->evidencia) }}" width="100" class="rounded border">
                            </div>
                        @endif
                        <input type="file" name="evidencia" class="form-control" accept="image/*">
                        <div class="form-text text-muted small">Deja este campo vacío si no deseas cambiar la imagen.</div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('pacientes.index') }}" class="btn btn-light border px-4">Cancelar</a>
                    <button type="submit" class="btn btn-warning px-5 fw-bold shadow">Actualizar Expediente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<@push('scripts')
    @vite(['resources/js/pages/pacientes.js'])
@endpush
@endsection