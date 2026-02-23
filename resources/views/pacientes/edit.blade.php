@extends('layouts.app')

@section('content')
<div class="container pb-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-warning text-dark py-3">
            <h3 class="mb-0 text-center">✏️ Editar Expediente: {{ $paciente->nombre }} {{ $paciente->apellido }}</h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="text-primary border-bottom pb-2 mb-3">1. Datos de Identificación</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipo de Doc.</label>
                        <select name="tipo_documento" class="form-select border-primary">
                            <option value="DNI" {{ $paciente->tipo_documento == 'DNI' ? 'selected' : '' }}>DNI (Perú)</option>
                            <option value="CUI" {{ $paciente->tipo_documento == 'CUI' ? 'selected' : '' }}>CUI (Extranjero)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">N° Documento</label>
                        <input type="text" name="dni" class="form-control border-primary" value="{{ $paciente->dni }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sexo</label>
                        <select name="sexo" class="form-select border-primary" required>
                            <option value="Masculino" {{ $paciente->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ $paciente->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ $paciente->sexo == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Estado Civil</label>
                        <input type="text" name="estado_civil" class="form-control" value="{{ $paciente->estado_civil }}">
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

                <h5 class="text-primary border-bottom pb-2 mb-3">2. Nacimiento y Origen</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ $paciente->fecha_nacimiento }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Edad</label>
                        <input type="text" name="edad" id="edad" class="form-control bg-light" value="{{ $paciente->edad }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nacionalidad</label>
                        <input type="text" name="nacionalidad" class="form-control" value="{{ $paciente->nacionalidad }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Lugar de Nac.</label>
                        <input type="text" name="lugar_nacimiento" class="form-control" value="{{ $paciente->lugar_nacimiento }}">
                    </div>
                </div>

                <h5 class="text-primary border-bottom pb-2 mb-3">3. Ubicación y Contacto</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="{{ $paciente->direccion }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Localidad</label>
                        <input type="text" name="localidad" class="form-control" value="{{ $paciente->localidad }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ $paciente->telefono }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-danger">⚠️ Alergias y Advertencias Médicas</label>
                    <textarea name="alergias" class="form-control border-danger" rows="3">{{ $paciente->alergias }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn btn-warning px-5 fw-bold shadow">Actualizar Expediente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Mantenemos la lógica de cálculo de edad en edición
    document.getElementById('fecha_nacimiento').addEventListener('change', function() {
        const fechaNacimiento = new Date(this.value);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        const mes = hoy.getMonth() - fechaNacimiento.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) { edad--; }
        document.getElementById('edad').value = isNaN(edad) ? 0 : edad;
    });
</script>
@endsection