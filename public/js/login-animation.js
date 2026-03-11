document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const loader = document.getElementById('loader-sesion');
    const mainText = document.getElementById('texto-carga');
    const bar = document.getElementById('bar-fill');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Detiene el envío real
            
            loader.classList.remove('d-none'); // Muestra la pantalla

            // Los 3 pasos solicitados
            const etapas = [
                { t: "¡Sesión iniciada!", p: "33%" },
                { t: "Su panel está cargando...", p: "66%" },
                { t: "¡Gracias por elegir nuestro sistema!", p: "100%" }
            ];

            let actual = 0;
            const timer = setInterval(() => {
                if (actual < etapas.length) {
                    // Animación de desvanecimiento de texto
                    mainText.style.opacity = 0;
                    
                    setTimeout(() => {
                        mainText.innerText = etapas[actual].t;
                        bar.style.width = etapas[actual].p;
                        mainText.style.opacity = 1;
                        actual++;
                    }, 300);
                }

                // Al completar los 3 segundos
                if (actual === 3) {
                    clearInterval(timer);
                    setTimeout(() => {
                        form.submit(); // Envía el formulario a Laravel
                    }, 800);
                }
            }, 1000);
        });
    }
});