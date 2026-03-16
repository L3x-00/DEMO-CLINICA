document.addEventListener("DOMContentLoaded", function() {
    // --- LÓGICA DE EDAD ---
    const inputFecha = document.getElementById('fecha_nacimiento');
    const inputEdad = document.getElementById('edad');

    if (inputFecha && inputEdad) {
        inputFecha.addEventListener('input', function() { // Cambiado 'change' por 'input' para mayor respuesta
            if (!this.value) {
                inputEdad.value = 0;
                return;
            }

            const fechaNacimiento = new Date(this.value);
            const hoy = new Date();
            
            let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            const mes = hoy.getMonth() - fechaNacimiento.getMonth();

            // Ajuste preciso
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) { 
                edad--; 
            }

            // Asignar valor (evitar negativos y NaN)
            inputEdad.value = (isNaN(edad) || edad < 0) ? 0 : edad;
        });
    }

    // --- BUSCADOR EN TIEMPO REAL (Migrado desde show.blade.php) ---
    const buscarPaciente = document.getElementById('buscarPaciente');
    const resultados = document.getElementById('resultadosBusqueda');

    if (buscarPaciente && resultados) {
        buscarPaciente.addEventListener('input', function() {
            let query = this.value;
            if (query.length >= 2) {
                fetch(`/buscar-pacientes-json?q=${query}`)
                    .then(res => res.json())
                    .then(data => {
                        resultados.innerHTML = '';
                        if (data.length > 0) {
                            resultados.classList.remove('d-none');
                            data.forEach(p => {
                                const item = document.createElement('a');
                                item.className = "list-group-item list-group-item-action py-2";
                                item.style.cursor = "pointer";
                                item.innerHTML = `
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>${p.nombre}</strong>
                                        <span class="badge bg-secondary rounded-pill small">${p.dni}</span>
                                    </div>`;
                                item.onclick = () => {
                                    buscarPaciente.value = p.nombre;
                                    const hiddenInput = document.getElementById('paciente_id_hidden');
                                    if(hiddenInput) hiddenInput.value = p.id;
                                    resultados.classList.add('d-none');
                                };
                                resultados.appendChild(item);
                            });
                        }
                    });
            } else { resultados.classList.add('d-none'); }
        });

        document.addEventListener('click', (e) => {
            if (!buscarPaciente.contains(e.target)) resultados.classList.add('d-none');
        });
    }
});