@extends('layouts.app')

@section('content')
<div class="container pb-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white py-3">
            <h3 class="mb-0 flex-grow-1 text-center">📝 Registro de Historia Clínica</h3>
        </div>
        <div class="card-body p-4">
            {{-- SE CORRIGIÓ: Un solo formulario con enctype para permitir imágenes --}}
            <form action="{{ route('pacientes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="text-primary border-bottom pb-2 mb-3">1. Datos de Identificación</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipo de Doc.</label>
                        <select name="tipo_documento" class="form-select border-primary" required>
                            <option value="DNI">DNI</option>
                            <option value="CUI">CUI (Extranjero)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">N° Documento</label>
                        <input type="text" name="dni" class="form-control border-primary" placeholder="Ej: 74385642" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sexo</label>
                        <select name="sexo" class="form-select border-primary" required>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Estado Civil</label>
                        <select name="estado_civil" class="form-select border-primary">
                            <option value="Soltero/a">Soltero/a</option>
                            <option value="Casado/a">Casado/a</option>
                            <option value="Divorciado/a">Divorciado/a</option>
                            <option value="Viudo/a">Viudo/a</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombres</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Apellidos</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                </div>

                <h5 class="text-primary border-bottom pb-2 mb-3">2. Nacimiento y Origen</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Edad</label>
                        <input type="text" name="edad" id="edad" class="form-control bg-light" readonly placeholder="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nacionalidad</label>
                        <input type="text" name="nacionalidad" class="form-control" value="Peruana">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Lugar de Nac.</label>
                        <input type="text" name="lugar_nacimiento" class="form-control">
                    </div>
                </div>

                <h5 class="text-primary border-bottom pb-2 mb-3">3. Ubicación y Contacto</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Dirección Actual</label>
                        <input type="text" name="direccion" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Provincia</label>
                        <input type="text" name="provincia" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Distrito</label>
                        <input type="text" name="distrito" class="form-control">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" placeholder="paciente@ejemplo.com">
                    </div>
                </div>

                <h5 class="text-primary border-bottom pb-2 mb-3">4. Información Laboral y Salud</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Profesión</label>
                        <input type="text" name="profesion" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ocupación</label>
                        <input type="text" name="ocupacion" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Lugar Laboral</label>
                        <input type="text" name="lugar_laboral" class="form-control">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-danger">⚠️ Alergias y Advertencias Médicas</label>
                    <textarea name="alergias" class="form-control border-danger" rows="3" placeholder="Describa alergias..."></textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="bi bi-clipboard2-pulse me-2"></i>Antecedentes Médicos</label>
                        <textarea name="antecedentes" class="form-control" rows="3" placeholder="Cirugías, enfermedades..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="bi bi-chat-left-text me-2"></i>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Notas adicionales..."></textarea>
                    </div>
                </div>

                {{-- SECCIÓN DE EVIDENCIA --}}
                <div class="row mb-5">
                    <div class="col-12">
                        <label class="form-label fw-bold"><i class="bi bi-camera me-2 text-primary"></i>Subir Evidencia (Imagen)</label>
                        <input type="file" name="evidencia" class="form-control" accept="image/*">
                        <div class="form-text text-muted small">Formatos permitidos: JPG, PNG, WEBP.</div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('pacientes.index') }}" class="btn btn-light border px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow">Guardar Registro Médico</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('fecha_nacimiento').addEventListener('change', function() {
        const fechaNacimiento = new Date(this.value);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        const mes = hoy.getMonth() - fechaNacimiento.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }
        document.getElementById('edad').value = isNaN(edad) ? 0 : edad;
    });
</script>
@endsection