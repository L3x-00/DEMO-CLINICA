// 1. UTILIDADES INTERNAS

// Esta función cierra cualquier menú desplegable abierto antes de lanzar un modal
function cerrarDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-toggle.show');
    dropdowns.forEach(toggle => {
        menu.classList.remove('show');
        menu.style.visibility = 'hidden';
        menu.style.display = 'none';
    });
}
//2. FUNCIONES GLOBALES (ACCESIBLES DESDE EL HTML)
window.abrirModalDiagnostico = function(id, nombre, dni) {
    cerrarDropdowns(); // Cerramos el menú de "Acciones"
    const inputId = document.getElementById('paciente_id_hidden');
    const displayName = document.getElementById('nombrePacienteDisplay');
    const displayDni = document.getElementById('dniPacienteDisplay');
    const form = document.getElementById('formDiagnostico');
    if (inputId) inputId.value = id;
    if (displayName) displayName.innerText = nombre;
    if (displayDni) displayDni.innerText = 'DNI: ' + dni;
    if (form) {
        form.reset();
        // El ID debe re-asignarse porque reset() limpia todo el form
        document.getElementById('paciente_id_hidden').value = id;
    }

    const modalEl = document.getElementById('modalDiagnostico');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}
window.abrirModalDerivacion = function(id, nombre) {
    cerrarDropdowns(); // Cerramos el menú de "Acciones"
    const inputId = document.getElementById('derivar_paciente_id');
    const displayName = document.getElementById('nombrePacienteDerivar');
    
    if (inputId) inputId.value = id;
    if (displayName) displayName.innerText = nombre;

    const modalEl = document.getElementById('modalDerivacion');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}
window.cambiarMontoSugerido = function() {
    const select = document.getElementById('selectServicio');
    const inputMonto = document.getElementById('monto_atencion');
    if (select && inputMonto) {
        const monto = select.options[select.selectedIndex].getAttribute('data-monto');
        inputMonto.value = monto || '';
    }
}
//3. LÓGICA PRINCIPAL DEL DOM
document.addEventListener("DOMContentLoaded", function() {
    console.log("Sistema de Pacientes: Listo.");

    // --- Auto-cierre de Dropdowns al sacar el puntero ---
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        dropdown.addEventListener('mouseleave', function() {
            const toggle = this.querySelector('.dropdown-toggle');
            const instance = bootstrap.Dropdown.getInstance(toggle);
            if (instance) instance.hide();
        });
    });
    // --- Inicializar Tooltips ---
    document.querySelectorAll('[title]').forEach(el => new bootstrap.Tooltip(el));
    // --- Cálculo de edad ---
    const inputFecha = document.getElementById('fecha_nacimiento');
    const inputEdad = document.getElementById('edad');
    if (inputFecha && inputEdad) {
        inputFecha.addEventListener('input', function() {
            if (!this.value) return inputEdad.value = 0;
            const birth = new Date(this.value);
            const today = new Date();
            let edad = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) edad--;
            inputEdad.value = (isNaN(edad) || edad < 0) ? 0 : edad;
        });
    }
    // --- Buscador en tiempo real ---
    const buscarPaciente = document.getElementById('buscarPaciente');
    const resultados = document.getElementById('resultadosBusqueda');
    if (buscarPaciente && resultados) {
        buscarPaciente.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                fetch(`/buscar-pacientes-json?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        resultados.innerHTML = '';
                        if (data.length > 0) {
                            resultados.classList.remove('d-none');
                            data.forEach(p => {
                                const item = document.createElement('a');
                                item.className = "list-group-item list-group-item-action py-2";
                                item.innerHTML = `<strong>${p.nombre}</strong> <small class="text-muted ms-2">${p.dni}</small>`;
                                item.onclick = (e) => {
                                    e.preventDefault();
                                    buscarPaciente.value = p.nombre;
                                    document.getElementById('paciente_id_hidden').value = p.id;
                                    resultados.classList.add('d-none');
                                };
                                resultados.appendChild(item);
                            });
                        } else { resultados.classList.add('d-none'); }
                    });
            } else { resultados.classList.add('d-none'); }
        });
        document.addEventListener('click', (e) => {
            if (!buscarPaciente.contains(e.target) && !resultados.contains(e.target)) {
                resultados.classList.add('d-none');
            }
            
        });
    }
    // --- Alerta de éxito (SweetAlert2) ---
    if (window.sessionSuccess) {
        Swal.fire({
            title: '¡Operación Exitosa!',
            text: window.sessionSuccess,
            icon: 'success',
            timer: 2500, // Un poco más rápido para no estorbar
            showConfirmButton: false,
            timerProgressBar: true,
            customClass: { 
                popup: 'rounded-4 shadow-lg border-0' 
            }
        });
    }
});