import TomSelect from "tom-select";

document.addEventListener("DOMContentLoaded", function() {
    // --- 1. LÓGICA PARA CREACIÓN (TomSelect y Alergias) ---
    const selectPaciente = document.getElementById('select-paciente');
    const campoResumen = document.querySelector('textarea[name="resumen_historia"]');

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
        });
    }

    // --- 2. LÓGICA PARA INDEX (Buscador y Filtros de Tiempo) ---
    const filterInput = document.getElementById('filterInput');
    const tableRows = document.querySelectorAll('table tbody tr'); // Selecciona las filas de la tabla
    const filterButtons = document.querySelectorAll('#timeFilters button');

    // Filtro por texto (Paciente, DNI, Diagnóstico)
    if (filterInput) {
        filterInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            tableRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                // Si la fila tiene el texto "Sin informes registrados", no la filtramos
                if (!row.classList.contains('no-result')) {
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                }
            });
        });
    }

    // Filtro por botones (Hoy, Ayer, Todos)
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
                    if (!dateSpan) return; // Saltar si es la fila de "no hay resultados"

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