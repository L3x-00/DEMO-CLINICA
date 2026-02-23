<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Clínica Local</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary">
    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="mb-3">
    <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
        ← Volver al inicio
    </a>
</div>
                    <div class="card-body p-4 text-center">
                        <h2 class="mb-3">Bienvenido, Doctor 👨‍⚕️</h2>
                        <p class="text-muted">Inicie sesión para acceder a sus pacientes</p>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Entrar al Sistema</button>
                        </form>
                        <a href="{{ route('register') }}" class="text-decoration-none small">¿No tiene cuenta? Regístrese aquí</a>
                    </div>
                </div>
                <p class="text-center text-white mt-3 mt-4"><small>&copy; 2026 Sistema Médico Local - V 1.0</small></p>
            </div>
        </div>
    </div>
</body>
</html>