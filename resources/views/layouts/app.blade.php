<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Clínica 🦴</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f1f3f5; }

        /* Barra superior azul */
        .top-navbar {
            background-color: #0d6efd;
            color: white;
            padding: 10px 25px;
            height: 70px;
        }

        .main-wrapper {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        /* Sidebar lateral */
        .sidebar {
            width: 280px;
            background-color: white;
            padding: 25px 15px;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
        }

        /* Botones del menú lateral */
        .nav-card {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin-bottom: 8px;
            border-radius: 12px;
            text-decoration: none;
            color: #495057;
            transition: all 0.2s ease;
            font-weight: 500;
            border: 1px solid transparent;
        }

        .nav-card:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
            transform: translateX(5px);
        }

        /* Clase activa (Color rojo según tu imagen) */
        .nav-card.active {
            background-color: #dc3545;
            color: white;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
        }

        .nav-card i {
            font-size: 1.2rem;
            margin-right: 12px;
        }

        /* Área de contenido principal */
        .content-area {
            flex-grow: 1;
            padding: 35px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <header class="top-navbar d-flex justify-content-between align-items-center shadow-sm">
        <h4 class="mb-0 fw-bold"><i class="bi bi-bone"></i> Gestión Clínica</h4>
        
        <div class="d-flex align-items-center">
            <div class="text-end me-3">
                <span class="d-block fw-bold leading-none">👤 {{ auth()->user()->name }}</span>
                <small class="text-white-50">Doctor Conectado</small>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm fw-bold px-3">
                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </header>

    <div class="main-wrapper">
        <aside class="sidebar shadow-sm">
            <h6 class="text-muted small text-uppercase fw-bold mb-4 px-3" style="letter-spacing: 1px;">Menú Principal</h6>
            
            <nav>
                <a href="{{ route('home') }}" class="nav-card {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Inicio</span>
                </a>

                <a href="{{ route('citas.index') }}" class="nav-card {{ request()->routeIs('citas.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i>
                    <span>Agenda</span>
                </a>

                <a href="{{ route('pacientes.index') }}" class="nav-card {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Pacientes</span>
                </a>
            </nav>

            <div class="mt-auto pt-5 text-center text-muted border-top">
                <small class="fw-bold">© 2026 Clínica Local</small>
            </div>
        </aside>

        <main class="content-area">
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    @stack('scripts')
</body>
</html>