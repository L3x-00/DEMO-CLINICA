@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0" style="border-radius: 20px; background-color: var(--card-bg);">
                <div class="card-header bg-primary text-white py-4" style="border-radius: 20px 20px 0 0;">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-plus-fill fs-2 me-3"></i>
                        <h3 class="mb-0 fw-bold">Registro de Nuevo Paciente</h3>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('pacientes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-7 border-end border-secondary border-opacity-10 pe-md-4">
                                <h5 class="text-primary fw-bold mb-4 d-flex align-items-center">
                                    <i class="bi bi-card-text me-2"></i> Información de Identidad
                                </h5>

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

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold opacity-75">NOMBRES</label>
                                        <input type="text" name="nombre" class="form-control border-0 shadow-sm custom-input" style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" placeholder="Nombres del paciente" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold opacity-75">APELLIDOS</label>
                                        <input type="text" name="apellido" class="form-control border-0 shadow-sm custom-input" style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" placeholder="Apellidos completos" required>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
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
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold opacity-75">EDAD</label>
                                        <input type="text" name="edad" id="edad" class="form-control border-0  text-center fw-bold" readonly placeholder="0">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold opacity-75">SEXO</label>
                                        <select name="sexo" class="form-select border-0 shadow-sm custom-input" style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" required>
                                            <option value="Masculino">M</option>
                                            <option value="Femenino">F</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 ps-md-4 mt-4 mt-md-0">
                                <h5 class="text-primary fw-bold mb-4 d-flex align-items-center">
                                    <i class="bi bi-telephone-plus me-2"></i> Contacto y Consulta
                                </h5>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold opacity-75">TELÉFONO / CELULAR</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 bg-primary text-white"><i class="bi bi-whatsapp"></i></span>
                                        <input type="text" name="telefono" class="form-control border-0 shadow-sm custom-input"maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" placeholder="987 654 321">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold opacity-75">NACIONALIDAD</label>
                                    <input type="text" name="nacionalidad" class="form-control border-0 shadow-sm custom-input" style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" value="Peruana">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i> MOTIVO DE CONSULTA</label>
                                    <textarea name="alergias" class="form-control border-0 shadow-sm custom-input" rows="4" style="background-color: var(--bs-body-bg); color: var(--bs-body-color);" placeholder="¿Por qué acude el paciente?"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="p-3 rounded-4 border-dashed text-center">
                                    <label class="form-label fw-bold mb-2"><i class="bi bi-image me-2 text-primary"></i>Fotografía o Documento Auxiliar</label>
                                    <input type="file" name="evidencia" class="form-control border-0 shadow-none mx-auto" style="max-width: 400px;" accept="image/*">
                                    <div class="form-text small opacity-50">Formatos: JPG, PNG, WEBP (Máx. 2MB)</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                            <a href="{{ route('pacientes.index') }}" class="btn btn-danger rounded-pill px-4 fw-bold">
                                <i class="bi bi-x-circle me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-lg">
                                <i class="bi bi-check2-circle me-2"></i>Guardar Registro Médico
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    @vite(['resources/js/pages/pacientes.js'])
@endpush