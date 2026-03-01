<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCore Pro | Sistema de Gestión Traumatológica Avanzada 🏥</title>
    
    <!-- Bootstrap 5.3.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            /* Paleta de colores médicos profesionales */
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #13B497 0%, #1E90FF 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-gradient: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
            
            /* Colores base */
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --success-color: #13B497;
            --info-color: #4facfe;
            --warning-color: #fa709a;
            --dark-color: #1a202c;
            --light-color: #f7fafc;
            
            /* Sombras profesionales */
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px rgba(0,0,0,0.1);
            --shadow-2xl: 0 25px 50px rgba(0,0,0,0.15);
            
            /* Bordes y radios */
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            
            /* Transiciones */
            --transition-fast: all 0.15s ease;
            --transition-normal: all 0.3s ease;
            --transition-slow: all 0.5s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar Profesional */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition-normal);
            z-index: 1000;
        }

        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: var(--transition-fast);
        }

        .navbar-brand:hover {
            transform: translateX(5px);
        }

        .btn-welcome {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: var(--radius-lg);
            transition: var(--transition-normal);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .btn-welcome::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-welcome:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: white;
            backdrop-filter: blur(10px);
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            transform: translateY(-2px);
        }

        /* Hero Section Avanzada */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,106.7C1248,96,1344,96,1392,96L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-30px, -30px) rotate(180deg); }
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 2rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Carousel Moderno */
        .carousel-modern {
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-2xl);
            background: white;
        }

        .carousel-modern img {
            height: 500px;
            object-fit: cover;
        }

        .carousel-caption-custom {
            background: rgba(26, 32, 44, 0.9);
            backdrop-filter: blur(20px);
            padding: 2rem;
            border-radius: var(--radius-lg);
            margin: 0 auto;
            max-width: 600px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 1rem;
            transition: var(--transition-normal);
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: white;
            transform: translateY(-50%) scale(1.1);
        }

        /* Cards de Características */
        .card-feature {
            background: white;
            border-radius: var(--radius-xl);
            padding: 3rem 2rem;
            text-align: center;
            transition: var(--transition-normal);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .card-feature::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: var(--transition-normal);
        }

        .card-feature:hover::before {
            transform: scaleX(1);
        }

        .card-feature:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-2xl);
        }

        .feature-icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            background: var(--primary-gradient);
            color: white;
            transition: var(--transition-normal);
        }

        .card-feature:hover .feature-icon-box {
            transform: rotate(360deg) scale(1.1);
        }

        /* Sección de Módulos Detallados */
        .modules-section {
            background: linear-gradient(135deg, #f6f8fb 0%, #e9ecef 100%);
            padding: 80px 0;
            position: relative;
        }

        .modules-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: white;
            transform: skewY(-3deg);
            transform-origin: top left;
        }

        .module-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            border-left: 4px solid;
        }

        .module-card:hover {
            transform: translateX(10px);
            box-shadow: var(--shadow-xl);
        }

        .module-card.pacientes { border-left-color: #667eea; }
        .module-card.agenda { border-left-color: #13B497; }
        .module-card.informes { border-left-color: #4facfe; }
        .module-card.imagenes { border-left-color: #fa709a; }
        .module-card.facturacion { border-left-color: #f093fb; }
        .module-card.inventario { border-left-color: #fee140; }

        .module-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .module-card.pacientes .module-icon { background: var(--primary-gradient); }
        .module-card.agenda .module-icon { background: var(--success-gradient); }
        .module-card.informes .module-icon { background: var(--info-gradient); }
        .module-card.imagenes .module-icon { background: var(--warning-gradient); }
        .module-card.facturacion .module-icon { background: var(--secondary-gradient); }
        .module-card.inventario .module-icon { background: var(--warning-gradient); }

        /* Estadísticas Avanzadas */
        .stats-advanced {
            background: var(--dark-gradient);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-advanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,106.7C1248,96,1344,96,1392,96L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .stat-box {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition-normal);
        }

        .stat-box:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Testimonios */
        .testimonials-section {
            background: white;
            padding: 80px 0;
        }

        .testimonial-card {
            background: linear-gradient(135deg, #f6f8fb 0%, #ffffff 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            margin-bottom: 2rem;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 1rem;
            left: 1.5rem;
            font-size: 4rem;
            color: var(--primary-color);
            opacity: 0.2;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            border: 3px solid var(--primary-color);
        }

        /* Footer Profesional */
        .footer-simple {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: white;
            padding: 60px 0 40px;
            position: relative;
            overflow: hidden;
        }

        .footer-simple::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--primary-gradient);
        }

        .footer-brand {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Badges y Etiquetas */
        .badge-gradient {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .badge-primary-gradient {
            background: var(--primary-gradient);
            color: white;
        }

        .badge-success-gradient {
            background: var(--success-gradient);
            color: white;
        }

        .badge-info-gradient {
            background: var(--info-gradient);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .btn-welcome {
                padding: 0.6rem 1.5rem;
                font-size: 0.8rem;
            }
            
            .carousel-modern img {
                height: 300px;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }

        /* Animaciones adicionales */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in-up.active {
            opacity: 1;
            transform: translateY(0);
        }

        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        /* Efectos de hover avanzados */
        .hover-lift {
            transition: var(--transition-normal);
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        /* Loading Animation */
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(102, 126, 234, 0.2);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Tooltips personalizados */
        .tooltip-custom {
            position: relative;
        }

        .tooltip-custom::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #2d3748;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
            margin-bottom: 0.5rem;
        }

        .tooltip-custom:hover::after {
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Navbar Profesional -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <i class="bi bi-hospital fs-3 me-2"></i> 
                <span style="letter-spacing: -0.5px;">MediCore Pro</span>
            </a>
            
            <div class="ms-auto d-flex gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-welcome btn-primary shadow-sm">
                            <i class="bi bi-grid-fill me-2"></i> Panel Principal
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-welcome btn-outline-primary fw-bold px-4">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-welcome btn-primary shadow-sm">
                            <i class="bi bi-person-plus me-2"></i> Registrarse
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section Mejorada -->
    <header class="hero-section text-white">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    @auth
                        <div class="hero-badge">
                            <i class="bi bi-shield-check-fill me-2"></i>
                            <span>SESIÓN ACTIVA - DR. {{ strtoupper(auth()->user()->name) }}</span>
                        </div>
                        <h1 class="hero-title fw-bold mb-4">
                            Bienvenido al Sistema<br>
                            <span class="text-light">de Gestión Médica</span>
                        </h1>
                        <p class="lead mb-5 opacity-90 fs-4">
                            Acceda instantáneamente a expedientes, agenda y herramientas diagnósticas. 
                            Su práctica médica optimizada al máximo nivel.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('home') }}" class="btn btn-welcome btn-light btn-lg text-primary shadow-lg">
                                <i class="bi bi-speedometer2 me-2"></i> Ir al Panel de Control
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                            <a href="#modules" class="btn btn-welcome btn-outline-light btn-lg">
                                <i class="bi bi-info-circle me-2"></i> Ver Módulos
                            </a>
                        </div>
                    @else
                        <div class="hero-badge">
                            <i class="bi bi-star-fill me-2"></i>
                            <span>SISTEMA MÉDICO PROFESIONAL</span>
                        </div>
                        <h1 class="hero-title fw-bold mb-4">
                            Gestión Traumatológica<br>
                            <span class="text-warning">de Nueva Generación</span>
                        </h1>
                        <p class="lead mb-5 opacity-90 fs-4">
                            Plataforma integral para clínicas traumatológicas. Digitalice, optimice y 
                            transforme su práctica médica con tecnología de vanguardia.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#modules" class="btn btn-welcome btn-light btn-lg text-primary shadow-lg">
                                <i class="bi bi-layers me-2"></i> Explorar Módulos
                                <i class="bi bi-arrow-down ms-2"></i>
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-welcome btn-outline-light btn-lg">
                                <i class="bi bi-rocket-takeoff me-2"></i> Comenzar Gratis
                            </a>
                        </div>
                    @endauth
                </div>
                <div class="col-lg-5">
                    <div class="position-relative" data-aos="fade-left">
                        <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?auto=format&fit=crop&w=800&q=80" 
                             class="img-fluid rounded-4 shadow-2xl" alt="Sistema Médico">
                        <div class="position-absolute top-0 start-0 translate-middle">
                            <div class="badge badge-gradient badge-success-gradient p-3">
                                <i class="bi bi-check-circle fs-4"></i>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 end-0 translate-middle">
                            <div class="badge badge-gradient badge-primary-gradient p-3">
                                <i class="bi bi-shield-lock fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Carrusel de Infraestructura -->
    <section class="container py-5 mt-n5 position-relative" style="z-index: 5;">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge badge-gradient badge-info-gradient mb-3">INFRAESTRUCTURA MÉDICA</span>
            <h2 class="display-5 fw-bold">Instalaciones de <span class="gradient-text">Vanguardia</span></h2>
            <p class="lead text-muted">Espacios diseñados para la excelencia en atención traumatológica</p>
        </div>
        
        <div id="clinicCarousel" class="carousel slide carousel-modern shadow-2xl" data-bs-ride="carousel" data-aos="fade-up">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#clinicCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#clinicCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#clinicCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1350&q=80" 
                         class="d-block w-100" alt="Consultorio">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="carousel-caption-custom">
                            <h4 class="fw-bold mb-2">
                                <i class="bi bi-hospital me-2"></i> Consultorios Especializados
                            </h4>
                            <p class="mb-0">Equipamiento de última generación para diagnóstico preciso</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1538108149393-fdfd81895907?auto=format&fit=crop&w=1350&q=80" 
                         class="d-block w-100" alt="Recepción">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="carousel-caption-custom">
                            <h4 class="fw-bold mb-2">
                                <i class="bi bi-people me-2"></i> Área de Recepción
                            </h4>
                            <p class="mb-0">Ambiente optimizado para experiencia del paciente</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1350&q=80" 
                         class="d-block w-100" alt="Quirófano">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="carousel-caption-custom">
                            <h4 class="fw-bold mb-2">
                                <i class="bi bi-shield-plus me-2"></i> Quirófanos Modernos
                            </h4>
                            <p class="mb-0">Tecnología avanzada para procedimientos quirúrgicos</p>
                        </div>
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

    <!-- Sección de Módulos Detallados -->
    <section id="modules" class="modules-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge badge-gradient badge-primary-gradient mb-3">MÓDULOS INTEGRADOS</span>
                <h2 class="display-5 fw-bold">Sistema Completo de <span class="gradient-text">Gestión Médica</span></h2>
                <p class="lead text-muted">Todas las herramientas que su clínica necesita en una plataforma unificada</p>
            </div>

            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="module-card pacientes">
                        <div class="module-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">
                            <i class="bi bi-folder2-open me-2"></i> Gestión de Pacientes
                        </h4>
                        <p class="text-muted mb-3">Historial clínico completo con antecedentes traumatológicos, evolución post-quirúrgica y seguimiento integral.</p>
                        <ul class="text-muted small">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Expedientes digitales seguros</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Registro de fracturas y lesiones</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Control de tratamientos</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="module-card agenda">
                        <div class="module-icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">
                            <i class="bi bi-clock-history me-2"></i> Agenda Inteligente
                        </h4>
                        <p class="text-muted mb-3">Sistema avanzado de programación con optimización de tiempos y gestión de urgencias traumatológicas.</p>
                        <ul class="text-muted small">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Citas automatizadas</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Recordatorios inteligentes</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Gestión de sobrecitas</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-right">
                    <div class="module-card informes">
                        <div class="module-icon">
                            <i class="bi bi-file-earmark-medical-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">
                            <i class="bi bi-clipboard-data me-2"></i> Informes Médicos
                        </h4>
                        <p class="text-muted mb-3">Generación de reportes clínicos con validez legal, estadísticas y análisis de datos traumatológicos.</p>
                        <ul class="text-muted small">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Reportes personalizables</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Análisis estadístico</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Exportación en múltiples formatos</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="module-card imagenes">
                        <div class="module-icon">
                            <i class="bi bi-x-ray"></i>
                        </div>
                        <h4 class="fw-bold mb-3">
                            <i class="bi bi-images me-2"></i> Imágenes Diagnósticas
                        </h4>
                        <p class="text-muted mb-3">Almacenamiento y visualización de estudios radiológicos con herramientas de análisis avanzado.</p>
                        <ul class="text-muted small">
                            <li><i class="bi bi-check-circle text-success me-2"></i>DICOM compatible</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Herramientas de medición</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Comparación de estudios</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-right">
                    <div class="module-card facturacion">
                        <div class="module-icon">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <h4 class="fw-bold mb-3">
                            <i class="bi bi-receipt me-2"></i> Facturación y Cobros
                        </h4>
                        <p class="text-muted mb-3">Sistema integrado de facturación con seguros médicos, control de pagos y gestión de copagos.</p>
                        <ul class="text-muted small">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Facturación electrónica</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Control de seguros</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Reportes financieros</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="module-card inventario">
                        <div class="module-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h4 class="fw-bold mb-3">
                            <i class="bi bi-shop me-2"></i> Inventario Médico
                        </h4>
                        <p class="text-muted mb-3">Control completo de insumos médicos, equipos traumatológicos y gestión de proveedores.</p>
                        <ul class="text-muted small">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Control de stock</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Alertas de reorden</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Trazabilidad de productos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Características Principales -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge badge-gradient badge-success-gradient mb-3">CARACTERÍSTICAS AVANZADAS</span>
                <h2 class="display-5 fw-bold">Por qué elegir <span class="gradient-text">MediCore Pro</span></h2>
                <p class="lead text-muted">Tecnología de punta diseñada específicamente para profesionales de la salud</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-feature h-100">
                        <div class="feature-icon-box">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Seguridad de Nivel Bancario</h4>
                        <p class="text-muted mb-0">Encriptación AES-256 y cumplimiento total de normativas HIPAA para protección de datos médicos.</p>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-feature h-100">
                        <div class="feature-icon-box">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Rendimiento Optimizado</h4>
                        <p class="text-muted mb-0">Acceso instantáneo a datos con arquitectura local que garantiza velocidad y disponibilidad 24/7.</p>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-feature h-100">
                        <div class="feature-icon-box">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Analytics Médico</h4>
                        <p class="text-muted mb-0">Dashboard en tiempo real con métricas clínicas, KPIs y predictores para toma de decisiones.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estadísticas Avanzadas -->
    <section class="stats-advanced">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold text-white">Impacto en la <span style="color: #f093fb;">Gestión Médica</span></h2>
                <p class="lead text-white-50">Resultados comprobados en clínicas asociadas</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-box">
                        <div class="stat-number" data-target="98">0</div>
                        <p class="mb-0 mt-2 text-white-50">% Satisfacción</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-box">
                        <div class="stat-number" data-target="500">0</div>
                        <p class="mb-0 mt-2 text-white-50">Médicos Activos</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-box">
                        <div class="stat-number" data-target="50">0</div>
                        <p class="mb-0 mt-2 text-white-50">K Pacientes/Mes</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="stat-box">
                        <div class="stat-number" data-target="24">0</div>
                        <p class="mb-0 mt-2 text-white-50">/7 Soporte</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="testimonials-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge badge-gradient badge-warning-gradient mb-3">TESTIMONIOS</span>
                <h2 class="display-5 fw-bold">Lo que dicen los <span class="gradient-text">Profesionales</span></h2>
                <p class="lead text-muted">Experiencias reales de médicos que confían en nuestro sistema</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <p class="mb-3">"MediCore Pro transformó completamente mi práctica. La eficiencia ha aumentado un 60% y puedo enfocarme más en mis pacientes."</p>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/seed/doctor1/50/50" class="author-avatar" alt="Dr. Rodríguez">
                            <div>
                                <h6 class="mb-0 fw-bold">Dr. Carlos Rodríguez</h6>
                                <small class="text-muted">Traumatólogo - Hospital Central</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <p class="mb-3">"La gestión de expedientes nunca fue tan fácil. El sistema intuitivo y el soporte técnico excepcional hacen la diferencia."</p>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/seed/doctor2/50/50" class="author-avatar" alt="Dra. Martínez">
                            <div>
                                <h6 class="mb-0 fw-bold">Dra. Ana Martínez</h6>
                                <small class="text-muted">Ortopedista - Clínica del Valle</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <p class="mb-3">"Invertir en MediCore Pro fue la mejor decisión. El ROI se vio en menos de 6 meses. Recomendado 100%."</p>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/seed/doctor3/50/50" class="author-avatar" alt="Dr. López">
                            <div>
                                <h6 class="mb-0 fw-bold">Dr. Miguel López</h6>
                                <small class="text-muted">Cirujano - Centro Médico Norte</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Profesional -->
    <footer class="footer-simple">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">
                        <i class="bi bi-hospital"></i> MediCore Pro
                    </div>
                    <p class="text-white-50 mb-3">
                        Sistema de gestión médica de vanguardia para clínicas traumatológicas. 
                        Tecnología local, seguridad máxima.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white-50 hover-lift">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="#" class="text-white-50 hover-lift">
                            <i class="bi bi-twitter fs-5"></i>
                        </a>
                        <a href="#" class="text-white-50 hover-lift">
                            <i class="bi bi-linkedin fs-5"></i>
                        </a>
                        <a href="#" class="text-white-50 hover-lift">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white fw-bold mb-3">Producto</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Características</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Módulos</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Seguridad</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Actualizaciones</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white fw-bold mb-3">Soporte</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Documentación</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Tutoriales</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white fw-bold mb-3">Empresa</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Sobre Nosotros</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Carreras</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Partners</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Blog</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white fw-bold mb-3">Legal</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Privacidad</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Términos</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Licencias</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">HIPAA</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-secondary my-4">
            
            <div class="text-center">
                <p class="text-white-50 mb-0">
                    © 2026 MediCore Pro. Todos los derechos reservados. 
                    <span class="ms-2">Versión 2.0.4 • Sistema Local</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inicializar AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animated Counter
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;

        const countUp = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(countUp, 10);
                } else {
                    counter.innerText = target;
                }
            });
        };

        // Trigger counter when stats section is visible
        const statsSection = document.querySelector('.stats-advanced');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    countUp();
                    observer.unobserve(entry.target);
                }
            });
        });

        observer.observe(statsSection);

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>