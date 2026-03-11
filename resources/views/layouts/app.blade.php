<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Clínica 🦴</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- VITE: Carga estilos y JS global --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')

    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            const bgColor = savedTheme === 'dark' ? '#121416' : '#f0f4f8';
            document.documentElement.style.backgroundColor = bgColor;
        })();
    </script>
</head>
<body>> 


    {{-- Loader de cierre de sesión --}}
    <div id="logout-loader" class="d-none">
        <div class="loader-content text-white">
            <div class="spinner-border text-light mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
            <h2 class="fw-bold">Cerrando sesión...</h2>
        </div>
    </div>

    {{-- Navbar Superior --}}
    <header class="top-navbar shadow-sm">
        <div class="d-flex align-items-center">
            <button id="sidebar-toggle" class="btn btn-light d-lg-none me-3">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="mb-0 fw-bold text-primary">
                <i class="bi bi-activity me-2"></i> Gestión Clínica
            </h4>
        </div>

        <div class="d-flex align-items-center gap-2 gap-md-3">
            <button id="theme-toggle" class="btn btn-link text-body-emphasis border-0 p-2 shadow-none">
                <i id="theme-icon-light" class="bi bi-sun-fill fs-5 d-none"></i>
                <i id="theme-icon-dark" class="bi bi-moon-stars-fill fs-5"></i>
            </button>

            <div class="vr mx-2 opacity-25" style="height: 30px;"></div>

            <div class="text-end d-none d-sm-block">
                <span class="d-block fw-bold small">{{ auth()->user()->name }}</span>
                <span class="badge bg-success-subtle text-success border rounded-pill" style="font-size: 0.65rem;">En línea</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="m-0" id="logout-form">
                @csrf
                <button type="submit" class="btn bg-body-secondary border btn-sm px-3 rounded-3 shadow-sm" onclick="showLogoutLoader()">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </header>

    <div class="main-wrapper">
        {{-- Menú Lateral --}}
        <aside class="sidebar shadow-sm bg-body-tertiary border-end d-flex flex-column py-4">
            <h6 class="text-body-secondary small text-uppercase fw-bold mb-4 px-4 opacity-75" style="letter-spacing: 1.5px; font-size: 0.7rem;">
                Panel de Control
            </h6>
            
            <nav class="nav flex-column gap-1 px-2">
                <a href="{{ route('home') }}" class="nav-card {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('citas.index') }}" class="nav-card {{ request()->routeIs('citas.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3"></i> <span>Agenda Médica</span>
                </a>
                <a href="{{ route('pacientes.index') }}" class="nav-card {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> <span>Pacientes</span>
                </a>

                <div class="sidebar-divider my-2 opacity-25 border-top border-secondary mx-3"></div>

                @if(auth()->user()->role === 'asistente')
                <a href="{{ route('reportes.index') }}" class="nav-card {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i> <span>Informes</span>
                </a>
                <a href="{{ route('usuarios.index') }}" class="nav-card {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> <span>Usuarios</span>
                </a>
                @endif

                <div class="sidebar-divider my-2 opacity-25 border-top border-secondary mx-3"></div>

                <a href="{{ route('diagnostico.index') }}" class="nav-card {{ request()->routeIs('diagnostico.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-pulse"></i> <span>Diagnóstico</span>
                </a>
                <a href="{{ route('caja.index') }}" class="nav-card {{ request()->routeIs('caja.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> <span>Caja y Reportes</span>
                </a>
            </nav>

            <div class="mt-auto pt-4 text-center">
                <p class="text-body-secondary mb-1" style="font-size: 0.75rem;">© 2026 Clínica Traumatológica</p>
            </div>
        </aside>

        {{-- Contenido Principal --}}
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- JS Global para el Menú y Tema --}}
    @push('scripts')
        @vite(['resources/js/componentes/global.js'])
    @endpush

    @stack('scripts')
    
</body>
</html>