// 1. Seleccionamos el botón y los iconos
const btnToggle = document.getElementById('theme-toggle');
const iconLight = document.getElementById('theme-icon-light');
const iconDark = document.getElementById('theme-icon-dark');

// 2. Función para aplicar el tema
function aplicarTema(tema) {
    document.documentElement.setAttribute('data-theme', tema);
    localStorage.setItem('tema-preferido', tema);
    
    // Ajustamos los iconos según el tema
    if (tema === 'dark') {
        iconLight.classList.remove('d-none'); // Muestra Sol
        iconDark.classList.add('d-none');    // Oculta Luna
    } else {
        iconLight.classList.add('d-none');    // Oculta Sol
        iconDark.classList.remove('d-none'); // Muestra Luna
    }
}

// 3. Evento de clic para cambiar manualmente
btnToggle.addEventListener('click', () => {
    const temaActual = document.documentElement.getAttribute('data-theme');
    const nuevoTema = (temaActual === 'dark') ? 'light' : 'dark';
    aplicarTema(nuevoTema);
});

// 4. Al cargar la página, recuperar la preferencia guardada
const temaGuardado = localStorage.getItem('tema-preferido') || 'light';
aplicarTema(temaGuardado);
