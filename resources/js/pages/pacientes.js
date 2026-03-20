/**
 * Lógica para la gestión de Pacientes
 */

// 1. UTILIDADES INTERNAS
function cerrarDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-menu.show');
    dropdowns.forEach(menu => menu.classList.remove('show'));
}

// --- Función de Validación de Campos ---
const validarCampoPaciente = (input) => {
    const form = input.closest('form');
    if (!form) return;
    
    // --- LÓGICA DINÁMICA DNI (8) / CUI (15) ---
    // --- LÓGICA DINÁMICA DNI (8) / CUI (15) ---
    if (input.name === 'dni') {
        const selectTipo = form.querySelector('select[name="tipo_documento"]');
        const tipoDoc = selectTipo ? selectTipo.value : 'DNI';
        const errorMsg = document.getElementById('dni-error-msg'); // El div del HTML

        if (tipoDoc === 'DNI') {
            input.maxLength = 8;
            if (input.value.length !== 8) {
                input.setCustomValidity("Inválido");
                if (errorMsg) errorMsg.innerText = "El DNI debe tener exactamente 8 dígitos.";
            } else {
                input.setCustomValidity("");
            }
        } else if (tipoDoc === 'CUI') {
            input.maxLength = 15;
            if (input.value.length < 5) {
                input.setCustomValidity("Inválido");
                if (errorMsg) errorMsg.innerText = "El CUI debe tener entre 5 y 15 dígitos.";
            } else {
                input.setCustomValidity("");
            }
        }
    }

    // --- LÓGICA TELÉFONO (9) ---
    if (input.name === 'telefono') {
        input.maxLength = 9; // Bloquea físicamente en 9
        if (input.value.length > 0 && input.value.length < 9) {
            input.setCustomValidity("El teléfono debe tener 9 dígitos.");
        } else {
            input.setCustomValidity("");
        }
    }

    // Validación de Fecha
    if (input.name === 'fecha_nacimiento') {
        const hoy = new Date().toISOString().split('T')[0];
        if (input.value && input.value > hoy) {
            input.setCustomValidity("Fecha futura");
        } else {
            input.setCustomValidity("");
        }
    }

    // Aplicar clases de Bootstrap
    if (input.checkValidity()) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }
};

// 2. FUNCIONES GLOBALES (ACCESIBLES DESDE EL HTML)
window.abrirModalDiagnostico = function(id, nombre, dni) {
    cerrarDropdowns();
    const inputId = document.getElementById('paciente_id_hidden');
    const displayName = document.getElementById('nombrePacienteDisplay');
    const displayDni = document.getElementById('dniPacienteDisplay');
    const form = document.getElementById('formDiagnostico');

    if (form) {
        form.reset();
        form.classList.remove('was-validated');
    }
    if (inputId) inputId.value = id;
    if (displayName) displayName.innerText = nombre;
    if (displayDni) displayDni.innerText = 'DNI: ' + (dni || 'No registrado');

    const modalEl = document.getElementById('modalDiagnostico');
    if (modalEl) bootstrap.Modal.getOrCreateInstance(modalEl).show();
};

window.abrirModalDerivacion = function(id, nombre) {
    cerrarDropdowns();
    const inputId = document.getElementById('derivar_paciente_id');
    const displayName = document.getElementById('nombrePacienteDerivar');
    
    if (inputId) inputId.value = id;
    if (displayName) displayName.innerText = nombre;

    const modalEl = document.getElementById('modalDerivacion');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
};

window.cambiarMontoSugerido = function() {
    const select = document.getElementById('selectServicio');
    const inputMonto = document.getElementById('monto_atencion');
    if (select && inputMonto) {
        const monto = select.options[select.selectedIndex].getAttribute('data-monto');
        inputMonto.value = monto || '';
    }
};

// 3. LÓGICA PRINCIPAL DEL DOM
document.addEventListener("DOMContentLoaded", function() {
    
    
    console.log("Sistema de Pacientes: Listo.");

    // --- VALIDACIÓN DE FORMULARIOS (Crear y Editar) ---
    const formsPaciente = document.querySelectorAll('form[action*="pacientes"]');
    formsPaciente.forEach(form => {
        form.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', () => validarCampoPaciente(input));
            input.addEventListener('change', () => validarCampoPaciente(input));
        });

        form.addEventListener('submit', function(e) {
            let formValido = true;
            form.querySelectorAll('input, select, textarea').forEach(input => {
                validarCampoPaciente(input);
                if (!input.checkValidity()) formValido = false;
            });

            if (!formValido || !form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Datos Incompletos',
                        text: 'Por favor, revisa los campos marcados en rojo.',
                        confirmButtonColor: '#3085d6'
                    });
                }
            }
            form.classList.add('was-validated');
        });
    });
    
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

    // --- Auto-cierre de Dropdowns al sacar el puntero ---
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        dropdown.addEventListener('mouseleave', function() {
            const toggle = this.querySelector('.dropdown-toggle');
            if (toggle) {
                const instance = bootstrap.Dropdown.getInstance(toggle);
                if (instance) instance.hide();
            }
        });
    });

    // --- Inicializar Tooltips ---
    document.querySelectorAll('[title]').forEach(el => new bootstrap.Tooltip(el));

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
                                    const hiddenId = document.getElementById('paciente_id_hidden');
                                    if(hiddenId) hiddenId.value = p.id;
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
            timer: 2500,
            showConfirmButton: false,
            timerProgressBar: true,
            customClass: { popup: 'rounded-4 shadow-lg border-0' }
        });
    }
    const selectDoc = document.querySelector('select[name="tipo_documento"]');
    const inputDoc = document.getElementById('dni');

    if (selectDoc && inputDoc) {
        selectDoc.addEventListener('change', function() {
            // 1. Limpiamos el valor para evitar que queden 8 números si pasa a CUI o viceversa
            inputDoc.value = ""; 
            // 2. Quitamos las clases de validación anteriores
            inputDoc.classList.remove('is-valid', 'is-invalid');
            // 3. Ejecutamos la validación para que actualice el maxLength inmediatamente
            validarCampoPaciente(inputDoc); 
        });
    }
});