<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Gestión Clínica 🦴</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @stack('styles')
    <script>
        (function () {
            // 1. Recuperamos el tema guardado
            const savedTheme = localStorage.getItem('theme') || 'light';
            
            // 2. Aplicamos el atributo de Bootstrap 5.3 inmediatamente
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            
            // 3. Forzamos el fondo del HTML para bloquear el blanco del navegador
            // Usamos exactamente los mismos colores de tu app.css optimizado
            const bgColor = savedTheme === 'dark' ? '#121416' : '#f0f4f8';
            document.documentElement.style.backgroundColor = bgColor;
        })();
    </script>

</head>
<body>
    @if(session('mostrar_bienvenida'))
    <div id="preloader">
        <div class="loader-content">
            <div class="loader-logo">
                <i class="bi bi-activity"></i>
            </div>
            <h2 class="loader-title">¡Bienvenido, Dr. {{ auth()->user()->name }}!</h2>
            <p class="loader-phrase">Sincronizando su agenda médica...</p>
            <div class="loader-bar">
                <div class="loader-progress"></div>
            </div>
        </div>
    </div>
    @endif

    <div id="logout-loader" class="d-none">
        <div class="loader-content text-white">
            <div class="spinner-border text-light mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
            <h2 class="fw-bold">Cerrando sesión...</h2>
            <p>Guardando cambios de forma segura.</p>
        </div>
    </div>

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
            {{-- BOTÓN DE TEMA MEJORADO --}}
            <button id="theme-toggle" class="btn btn-link text-body-emphasis border-0 p-2 shadow-none" title="Cambiar tema">
                <i id="theme-icon-light" class="bi bi-sun-fill fs-5 d-none"></i>
                <i id="theme-icon-dark" class="bi bi-moon-stars-fill fs-5"></i>
            </button>

            <div class="vr mx-1 mx-md-2 text-muted opacity-25" style="height: 30px;"></div>

            {{-- INFO DE USUARIO ADAPTABLE --}}
            <div class="text-end me-1 me-md-2 d-none d-sm-block">
                <span class="d-block fw-bold small text-body-emphasis">
                    {{ auth()->user()->name }}
                </span>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill py-1 px-2" style="font-size: 0.65rem;">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> En línea
                </span>
            </div>

            {{-- BOTÓN CERRAR SESIÓN ADAPTABLE --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" 
                        class="btn bg-body-secondary text-body-emphasis border btn-sm fw-bold px-3 rounded-3 shadow-sm hover-danger" 
                        title="Cerrar Sesión" 
                        onclick="showLogoutLoader()">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </header>

    <div class="main-wrapper">
        <aside class="sidebar shadow-sm bg-body-tertiary border-end d-flex flex-column py-4">
            {{-- TÍTULO DE SECCIÓN --}}
            <h6 class="text-body-secondary small text-uppercase fw-bold mb-4 px-4 opacity-75" style="letter-spacing: 1.5px; font-size: 0.7rem;">
                Panel de Control
            </h6>
            
            {{-- NAVEGACIÓN --}}
            <nav class="nav flex-column gap-1 px-2">
                <a href="{{ route('home') }}" class="nav-card {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('citas.index') }}" class="nav-card {{ request()->routeIs('citas.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3"></i>
                    <span>Agenda Médica</span>
                </a>
                <a href="{{ route('pacientes.index') }}" class="nav-card {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Pacientes</span>
                </a>
                <a href="{{ route('reportes.index') }}" class="nav-card {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Reportes</span>
                </a>
            </nav>

            {{-- FOOTER DE SIDEBAR --}}
            <div class="mt-auto pt-4 text-center border-top border-secondary border-opacity-10">
                <p class="text-body-secondary mb-1" style="font-size: 0.75rem;">© 2026 Clínica Traumatológica</p>
                <span class="badge bg-primary-subtle text-primary fw-normal py-1 px-2" style="font-size: 0.65rem;">
                    v1.0.4 - Local
                </span>
            </div>
        </aside>

        <main class="content-area">
            @yield('content')
        </main>
    </div>
    <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 10000;">
        <div id="toast-container" class="toast-container"></div>
    </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        /**
         * 1. LÓGICA DE BIENVENIDA (SPLASH SCREEN)
         */
        @if(session('mostrar_bienvenida'))
        (function() {
            const iniciarLoader = () => {
                const preloader = document.getElementById('preloader');
                const progressBar = document.querySelector('.loader-progress');
                if(progressBar) {
                    progressBar.style.animation = 'loadProgress 2.8s ease-in-out forwards';
                }
                setTimeout(() => {
                    if(preloader) {
                        preloader.classList.add('loader-hidden');
                        setTimeout(() => preloader.remove(), 600);
                    }
                }, 3000);
            };
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', iniciarLoader);
            } else {
                iniciarLoader();
            }
        })();
        @endif

        /**
         * 2. LÓGICA DE CIERRE DE SESIÓN (LOGOUT)
         */
        function showLogoutLoader() {
            const logoutLoader = document.getElementById('logout-loader');
            if (logoutLoader) {
                logoutLoader.classList.remove('d-none');
                logoutLoader.style.display = 'flex';
            }
        }
        /**
         /* * LÓGICA DE TEMA (DARK/LIGHT MODE) OPTIMIZADA 
        */
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;

            themeToggle.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                // 1. Cambiamos el atributo visual
                htmlElement.setAttribute('data-bs-theme', newTheme);
                
                // 2. Actualizamos el color de fondo del HTML para evitar flashes en esta sesión
                htmlElement.style.backgroundColor = newTheme === 'dark' ? '#121416' : '#f0f4f8';
                
                // 3. ¡IMPORTANTE! Guardamos para la siguiente página
                localStorage.setItem('theme', newTheme);
                
                // 4. Tu lógica para cambiar los iconos (Sun/Moon)
                actualizarIconosTema(newTheme);
            });
        });

        function actualizarIconosTema(tema) {
            const sunIcon = document.getElementById('theme-icon-light');
            const moonIcon = document.getElementById('theme-icon-dark');
            
            if (tema === 'dark') {
                sunIcon.classList.remove('d-none');
                moonIcon.classList.add('d-none');
            } else {
                sunIcon.classList.add('d-none');
                moonIcon.classList.remove('d-none');
            }
        }
        // Lógica para abrir/cerrar menú en móviles
        const btnSidebar = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');

        if(btnSidebar) {
            btnSidebar.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }

        // Cerrar menú si se hace clic fuera de él (opcional pero profesional)
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 992) {
                if (!sidebar.contains(e.target) && !btnSidebar.contains(e.target) && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>