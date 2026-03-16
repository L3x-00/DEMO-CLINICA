<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Clínica 🦴</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>
</head>
<body>

    {{-- Loader de sesión --}}
    <div id="logout-loader" class="d-none position-fixed w-100 h-100 bg-dark bg-opacity-50 d-flex flex-column justify-content-center align-items-center" style="z-index: 2000;">
        <div class="spinner-border text-primary mb-2" role="status"></div>
        <span class="text-white fw-bold">Cerrando sesión segura...</span>
    </div>

    <div class="app-layout">
        {{-- SIDEBAR FIJA Y ESTÁTICA --}}
        <aside class="sidebar-static">
            <div class="brand-box">
                <i class="bi bi-activity fs-3 text-primary"></i>
                <span class="brand-name">Policlínico<strong> SAN PEDRO</strong></span>
                <span class="brand-name">Policlínico</span>
                
            </div>

            <nav class="sidebar-nav">
                <div class="nav-group">PRINCIPAL</div>
                <a href="{{ route('home') }}" class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-columns-gap"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('citas.index') }}" class="nav-link-item {{ request()->routeIs('citas.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3-event"></i> <span>Agenda Médica</span>
                </a>
                <a href="{{ route('pacientes.index') }}" class="nav-link-item {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> <span>Pacientes</span>
                </a>

                @if(auth()->user()->role === 'asistente')
                    <div class="nav-group">SISTEMA</div>
                    <a href="{{ route('reportes.index') }}" class="nav-link-item {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart-steps"></i> <span>Informes</span>
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="nav-link-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                        <i class="bi bi-person-gear"></i> <span>Usuarios</span>
                    </a>
                @endif

                <div class="nav-group">OPERACIONES</div>
                <a href="{{ route('caja.index') }}" class="nav-link-item {{ request()->routeIs('caja.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> <span>Caja y Reportes</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <small>© 2026 Clínica Traumatológica</small>
            </div>
        </aside>

        <div class="main-container">
            {{-- NAVBAR SUPERIOR DERECHA --}}
            <header class="top-header">
                <div class="ms-auto d-flex align-items-center gap-3">
                    
                    {{-- Tema --}}
                    <button id="theme-toggle" class="btn btn-icon shadow-none border-0 text-body">
                        <i id="theme-icon-light" class="bi bi-sun-fill d-none fs-5"></i>
                        <i id="theme-icon-dark" class="bi bi-moon-stars-fill fs-5"></i>
                    </button>

                    <div class="vr opacity-25" style="height: 25px;"></div>

                    {{-- Perfil de Usuario con Estado --}}
                    <div class="d-flex align-items-center gap-3 bg-body-tertiary px-3 py-1 rounded-3 border">
                        <div class="text-end lh-sm">
                            <span class="d-block fw-bold small">{{ auth()->user()->name }}</span>
                            <span class="status-indicator active">Activo</span>
                        </div>
                        <div class="user-avatar bg-primary text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>

                    {{-- Botón Salir --}}
                    <form action="{{ route('logout') }}" method="POST" class="m-0" id="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-3 shadow-sm border" onclick="showLogoutLoader()">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </header>

            {{-- ÁREA DE DESPLAZAMIENTO --}}
            <main class="content-scroll">
                <div class="container-fluid p-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @vite(['resources/js/componentes/global.js'])
</body>
</html>