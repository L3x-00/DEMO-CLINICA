<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente - MUESTRA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Editar Información del Paciente ✏️</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST">
                            @csrf 
                            @method('PUT') <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" value="{{ $paciente->nombre }}" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" name="apellido" class="form-control" value="{{ $paciente->apellido }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">DNI (8 dígitos)</label>
                                    <input type="text" name="dni" class="form-control" value="{{ $paciente->dni }}" maxlength="8" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control" value="{{ $paciente->telefono }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Historial Médico / Notas Actualizadas</label>
                                <textarea name="historial_medico" class="form-control" rows="4">{{ $paciente->historial_medico }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-warning">Actualizar Datos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>