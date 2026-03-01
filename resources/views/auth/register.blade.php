<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Doctor - Gestión Clínica 🦴</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="btn btn-link text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left-circle-fill me-1"></i> Volver al portal
                    </a>
                </div>

                <div class="card register-card border-0 shadow-lg">
                    <div class="auth-header-accent"></div>
                    <div class="card-body p-4 p-lg-5">
                        
                        <div class="text-center mb-5">
                            <div class="mb-3">
                                <span class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block">
                                    <i class="bi bi-person-plus-fill text-primary fs-2"></i>
                                </span>
                            </div>
                            <h3 class="fw-bold text-dark">Nueva Cuenta</h3>
                            <p class="text-muted small">Únase a la plataforma de gestión traumatológica</p>
                        </div>

                        {{-- Manejo de Errores --}}
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4 small">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Nombre Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="name" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                           placeholder="Dr. Nombre Apellido" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           placeholder="doctor@clinica.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-secondary">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                        <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-secondary">Confirmar</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-shield-check text-muted"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control border-start-0" placeholder="••••••••" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-auth w-100 mt-4 text-white">
                                Crear Mi Cuenta <i class="bi bi-arrow-right-short ms-1"></i>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0 text-muted small">
                                ¿Ya tiene una cuenta? 
                                <a href="{{ route('login') }}" class="fw-bold text-primary text-decoration-none">Inicie Sesión aquí</a>
                            </p>
                        </div>
                    </div>
                </div>

                <p class="text-center text-muted mt-5 small">
                    &copy; 2026 Clínica Traumatológica <br> 
                    <span class="opacity-50">Tecnología para la Salud Local 🏥</span>
                </p>
            </div>
        </div>
    </div>
</body>
</html>