document.addEventListener('DOMContentLoaded', function() {
    // 1. Detectamos qué formulario está presente
    const loginForm = document.getElementById('loginForm'); // Por si se carga en el login
    const formConsulta = document.getElementById('formConsulta'); // Formulario de creación
    const formEditConsulta = document.getElementById('formEditConsulta'); // Formulario de edición
    const loader = document.getElementById('loader-sesion');

    // Función genérica para mostrar el loader médico
    const mostrarLoader = (mensaje) => {
        if (loader) {
            const textoCarga = document.getElementById('texto-carga');
            if (textoCarga) textoCarga.innerText = mensaje;
            loader.style.setProperty('display', 'flex', 'important');
        }
    };

    // Lógica para CREAR consulta
    if (formConsulta) {
        formConsulta.addEventListener('submit', function() {
            mostrarLoader("Guardando nueva consulta médica...");
        });
    }

    // Lógica para EDITAR consulta
    if (formEditConsulta) {
        formEditConsulta.addEventListener('submit', function() {
            mostrarLoader("Actualizando historial clínico...");
        });
    }
});