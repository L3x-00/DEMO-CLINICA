<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema - Gestión Clínica 🦴</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">

    <div id="loader-sesion">
        <div class="loader-card">
            <div class="medical-icon-container">
                <i class="bi bi-heart-pulse-fill pulse-animation"></i>
                <div class="pulse-ring"></div>
            </div>
            
            <h4 id="texto-carga" class="loader-title">Sistema de Gestión Clínica</h4>
            <p class="loader-subtitle">Iniciando protocolo de acceso...</p>
            
            <div class="progress-container">
                <div id="bar-fill" class="progress-fill"></div>
            </div>
            
            <div class="loader-footer">
                <i class="bi bi-shield-lock-fill me-2 text-primary"></i> 
                Conexión segura y encriptada
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                
                <div class="card login-card border-0 shadow-lg">
                    <div class="auth-header-accent"></div>
                    
                    <div class="card-body p-4 p-lg-5">
                        <div class="text-center mb-5">
                            <div class="mb-3">
                                <span class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block">
                                    <i class="bi bi-activity text-primary fs-1"></i>
                                </span>
                            </div>
                            <h3 class="fw-bold text-dark">Portal Médico</h3>
                            <p class="text-muted small">Ingrese sus credenciales de acceso</p>
                        </div>

                        <form id="loginForm" action="{{ route('login') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0" 
                                           placeholder="usuario@clinica.com" required autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label small fw-bold text-secondary text-uppercase mb-0">Contraseña</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="small text-decoration-none">¿Olvidó su clave?</a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0" 
                                           placeholder="••••••••" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-auth w-100 text-white shadow-sm">
                                Autenticar <i class="bi bi-shield-check ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
                        <i class="bi bi-house-door me-1"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/login-animation.js') }}"></script>
</body>
</html>