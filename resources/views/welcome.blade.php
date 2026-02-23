<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido | Sistema de Gestión Clínica 🩺</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(13, 110, 253, 0.8)), 
                        url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 80vh;
            color: white;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .btn-welcome {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: 0.3s;
        }

        .section-padding { padding: 80px 0; }
        
        /* Estilo del Carrusel */
        .carousel-item img {
            height: 500px;
            object-fit: cover;
            border-radius: 20px;
        }

        .card-feature {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: 0.3s;
            border-radius: 15px;
        }
        .card-feature:hover { transform: translateY(-10px); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">CLÍNICA TRAUMATOLÓGICA 🦴</a>
            <div>
                @if (Route::has('login'))
                    @auth
                        {{-- Si está logueado, botón directo al Dashboard --}}
                        <a href="{{ route('home') }}" class="btn btn-primary btn-welcome">
                            <i class="bi bi-speedometer2 me-1"></i> Ir al Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2 btn-welcome">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-welcome">Registrarse</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            @auth
                {{-- Contenido Hero para Usuario Autenticado --}}
                <h1 class="display-3 fw-bold mb-3">¡Bienvenido de nuevo, Dr. {{ auth()->user()->name }}! 👋</h1>
                <p class="lead mb-5">Su panel de control está actualizado con las citas de los próximos 7 días.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('home') }}" class="btn btn-light btn-lg btn-welcome text-primary shadow">
                        <i class="bi bi-house-door-fill me-1"></i> Acceder a mi Dashboard
                    </a>
                </div>
            @else
                {{-- Contenido Hero para Visitantes --}}
                <h1 class="display-3 fw-bold mb-3">Tu Salud es Nuestra Prioridad</h1>
                <p class="lead mb-5">Sistema integral de gestión para traumatología y ortopedia. Organiza tus citas y pacientes en un solo lugar.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#info" class="btn btn-light btn-lg btn-welcome text-primary">Saber más</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg btn-welcome">Empezar ahora</a>
                </div>
            @endauth
        </div>
    </section>

    <section class="container section-padding">
        <h2 class="text-center fw-bold mb-5">Nuestras Instalaciones 🏥</h2>
        <div id="clinicCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1350&q=80" class="d-block w-100" alt="Consultorio">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                        <h5>Consultorios Modernos</h5>
                        <p>Equipados con la última tecnología para diagnóstico.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1538108149393-fdfd81895907?auto=format&fit=crop&w=1350&q=80" class="d-block w-100" alt="Recepción">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                        <h5>Atención Personalizada</h5>
                        <p>Ambientes cómodos para tu pronta recuperación.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#clinicCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#clinicCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <section id="info" class="bg-light section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Gestión Eficiente 📊</h2>
                <p class="text-muted">Optimiza el flujo de trabajo de tu consultorio médico.</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="card card-feature p-4 h-100">
                        <div class="fs-1 mb-3">👤</div>
                        <h4 class="fw-bold">Gestión de Pacientes</h4>
                        <p class="text-muted">Registra historias clínicas, datos de contacto y antecedentes médicos de forma segura.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-feature p-4 h-100">
                        <div class="fs-1 mb-3">📅</div>
                        <h4 class="fw-bold">Agenda de Citas</h4>
                        <p class="text-muted">Control total sobre los horarios y motivos de consulta con un buscador inteligente.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-feature p-4 h-100">
                        <div class="fs-1 mb-3">🦴</div>
                        <h4 class="fw-bold">Traumatología Local</h4>
                        <p class="text-muted">Sistema adaptado específicamente para necesidades de consulta ortopédica.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 text-center bg-dark text-white">
        <p class="mb-0">© 2026 Clínica Traumatológica - Sistema Local de Salud 🏥</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>