document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loader = document.getElementById('loader-sesion');
    const barFill = document.getElementById('bar-fill');
    const subtitle = document.querySelector('.loader-subtitle');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            // 1. Evitamos el envío inmediato
            e.preventDefault();

            // 2. Mostramos el loader con Flexbox para centrar la tarjeta clínica
            loader.style.setProperty('display', 'flex', 'important');

            // 3. Configuración de la animación
            let progreso = 0;
            
            const intervalo = setInterval(() => {
                progreso += 1; // Incremento suave de 1 en 1
                
                // Aseguramos que barFill exista antes de asignar el ancho
                if (barFill) {
                    barFill.style.width = progreso + '%';
                }

                // 4. Cambio dinámico de subtítulos clínicos según el avance
                if (subtitle) {
                    if (progreso === 15) subtitle.innerText = "Validando identidad biométrica...";
                    if (progreso === 45) subtitle.innerText = "Estableciendo túnel seguro...";
                    if (progreso === 75) subtitle.innerText = "Sincronizando expedientes clínicos...";
                    if (progreso === 95) subtitle.innerText = "Acceso concedido. Bienvenido.";
                }

                // 5. Finalización y envío del formulario
                if (progreso >= 100) {
                    clearInterval(intervalo);
                    loginForm.submit(); 
                }
            }, 30); // Velocidad equilibrada (~3 segundos totales de carga profesional)
        });
    }
});