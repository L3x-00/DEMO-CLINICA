import TomSelect from "tom-select";

document.addEventListener("DOMContentLoaded", function() {
    // --- 0. FUNCIÓN DE VALIDACIÓN (NUEVA) ---
    const validarCampoReporte = (input) => {
        if (input.hasAttribute('required') && input.value.trim() === '') {
            input.setCustomValidity("Requerido");
        } else {
            input.setCustomValidity("");
        }

        // Aplicar clases visuales de Bootstrap
        if (input.checkValidity()) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    };

    // --- 1. LÓGICA PARA CREACIÓN (TomSelect y Alergias) ---
    const selectPaciente = document.getElementById('select-paciente');
    const campoResumen = document.querySelector('textarea[name="resumen_historia"]');
    const formReporte = document.getElementById('formReporte');

    if (selectPaciente) {
        const ts = new TomSelect(selectPaciente, {
            create: false,
            sortField: { field: "text", direction: "asc" }
        });

        ts.on('change', function(value) {
            const option = selectPaciente.querySelector(`option[value="${value}"]`);
            if (option && campoResumen) {
                const alergias = option.getAttribute('data-alergias');
                campoResumen.value = alergias || 'Ninguna conocida';
                
                campoResumen.classList.add('is-valid');
                setTimeout(() => campoResumen.classList.remove('is-valid'), 1500);
            }
            // Validar el select al cambiar
            validarCampoReporte(selectPaciente);
        });
    }

    // Validación en tiempo real para el formulario de creación
    if (formReporte) {
        formReporte.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('input', () => validarCampoReporte(input));
        });

        formReporte.addEventListener('submit', function(e) {
            let esValido = true;
            formReporte.querySelectorAll('input, textarea, select').forEach(input => {
                validarCampoReporte(input);
                if (!input.checkValidity()) esValido = false;
            });

            if (!esValido) {
                e.preventDefault();
                e.stopPropagation();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Informe Incompleto',
                        text: 'Por favor, llene los campos obligatorios (Diagnóstico y Tratamiento).',
                        confirmButtonColor: '#3085d6'
                    });
                }
            }
            formReporte.classList.add('was-validated');
        });
    }

    // --- 2. LÓGICA PARA INDEX (Buscador y Filtros de Tiempo) ---
    const filterInput = document.getElementById('filterInput');
    const tableRows = document.querySelectorAll('table tbody tr'); 
    const filterButtons = document.querySelectorAll('#timeFilters button');

    if (filterInput) {
        filterInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            tableRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (!row.classList.contains('no-result')) {
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                }
            });
        });
    }

    if (filterButtons.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.dataset.filter;
                const today = new Date().toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                
                const yesterdayDate = new Date();
                yesterdayDate.setDate(yesterdayDate.getDate() - 1);
                const yesterday = yesterdayDate.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });

                tableRows.forEach(row => {
                    const dateSpan = row.querySelector('td:first-child span');
                    if (!dateSpan) return; 

                    const dateCell = dateSpan.innerText.trim();
                    
                    if (filterValue === 'todos') {
                        row.style.display = '';
                    } else if (filterValue === 'hoy') {
                        row.style.display = (dateCell === today) ? '' : 'none';
                    } else if (filterValue === 'ayer') {
                        row.style.display = (dateCell === yesterday) ? '' : 'none';
                    }
                });
            });
        });
    }
});