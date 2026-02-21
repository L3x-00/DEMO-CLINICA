<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Paciente - MUESTRA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Registrar Nuevo Paciente 🩺</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pacientes.store') }}" method="POST">
                            @csrf <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" name="apellido" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">DNI (8 dígitos)</label>
                                    <input type="text" name="dni" class="form-control" maxlength="8" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Historial Médico / Notas</label>
                                <textarea name="historial_medico" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar Paciente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>