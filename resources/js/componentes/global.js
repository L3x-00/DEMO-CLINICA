document.addEventListener('DOMContentLoaded', function() {
    // 1. Sidebar Toggle para móviles
    const btnSidebar = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    if(btnSidebar && sidebar) {
        btnSidebar.addEventListener('click', () => sidebar.classList.toggle('active'));
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

    // Aplicar iconos al cargar
    updateIcons(htmlElement.getAttribute('data-bs-theme'));

    themeToggle?.addEventListener('click', () => {
        const newTheme = htmlElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        htmlElement.setAttribute('data-bs-theme', newTheme);
        htmlElement.style.backgroundColor = newTheme === 'dark' ? '#121416' : '#f0f4f8';
        localStorage.setItem('theme', newTheme);
        updateIcons(newTheme);
    });
});

// Función global para el loader
window.showLogoutLoader = function() {
    const loader = document.getElementById('logout-loader');
    if (loader) loader.classList.remove('d-none');
};