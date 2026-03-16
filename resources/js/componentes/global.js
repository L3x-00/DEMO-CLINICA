document.addEventListener('DOMContentLoaded', function() {
    // 1. Sidebar Toggle para móviles
    const btnSidebar = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if(btnSidebar && sidebar) {
        btnSidebar.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
        });

        // Cerrar sidebar al hacer clic fuera (en móviles)
        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && e.target !== btnSidebar) {
                sidebar.classList.remove('active');
            }
        });
    }

    // 2. Lógica de Tema (Dark/Light)
    const themeToggle = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;
    const sunIcon = document.getElementById('theme-icon-light');
    const moonIcon = document.getElementById('theme-icon-dark');

    const updateIcons = (tema) => {
        if (tema === 'dark') {
            sunIcon?.classList.remove('d-none');
            moonIcon?.classList.add('d-none');
        } else {
            sunIcon?.classList.add('d-none');
            moonIcon?.classList.remove('d-none');
        }
    };

    // Aplicar estado inicial de iconos
    updateIcons(htmlElement.getAttribute('data-bs-theme'));

    themeToggle?.addEventListener('click', () => {
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        // Cambiar atributo de Bootstrap 5.3
        htmlElement.setAttribute('data-bs-theme', newTheme);
        
        // Guardar preferencia
        localStorage.setItem('theme', newTheme);
        
        // Actualizar UI
        updateIcons(newTheme);
    });
});

// Función global para el loader de sesión
window.showLogoutLoader = function() {
    const loader = document.getElementById('logout-loader');
    if (loader) {
        loader.classList.remove('d-none');
        loader.classList.add('d-flex'); // Asegura que se centre el spinner
    }
};