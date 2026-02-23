<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Doctor - Sistema Local</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="mb-3">
                            <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
                                <i class="bi bi-arrow-left"></i> Volver al inicio
                            </a>
                        </div>
                        <h3 class="text-center mb-4">Crear Cuenta de Doctor 🩺</h3>

                        {{-- IMPORTANTE: Bloque para ver errores de validación --}}
                        @if ($errors->any())
                            <div class="alert alert-danger shadow-sm">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre Completo</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Contraseña</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                <small class="text-muted">Mínimo 8 caracteres.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
                                <strong>Registrar y Configurar</strong>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="mb-0 text-muted">
                        ¿Ya tienes una cuenta registrada? 
                        <a href="{{ route('login') }}" class="fw-bold text-primary text-decoration-none">
                            Inicia Sesión aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>