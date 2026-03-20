/**
 * Lógica para la gestión de Citas (Index, Crear, Editar, Ver)
 */

document.addEventListener("DOMContentLoaded", function() {
    // --- 1. VALIDACIÓN EN TIEMPO REAL ---
    const validarCampo = (input) => {
        if (input.checkValidity()) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    };

    // Agregar listeners a formularios
    ['formCrearCita', 'formEditarCita'].forEach(formId => {
        const form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener('submit', function(e) {
            // 1. Ejecutar validación de fecha/hora manualmente antes de evaluar el form
            const esFechaValida = (formId === 'formCrearCita') ? validarFechaHora() : true;

            // 2. Verificar si el formulario completo es válido según el navegador
            if (!form.checkValidity() || !esFechaValida) {
                e.preventDefault(); // <--- ESTO detiene el envío a Laravel
                e.stopPropagation();
                
                // Marcar visualmente todos los campos que faltan
                form.querySelectorAll('input, textarea, select').forEach(input => {
                    if (!input.checkValidity()) {
                        input.classList.add('is-invalid');
                    }
                });
                
                // Opcional: mostrar un mensaje rápido
                console.error("Formulario bloqueado: Datos inválidos.");
            }
            
            form.classList.add('was-validated');
        });
    });

   // --- 2. LÓGICA DE FECHA Y HORA MÍNIMA ---
    const inputFecha = document.getElementById('fecha_crear');
    const inputHora = document.getElementById('hora_crear');

    function validarFechaHora() {
        if (!inputFecha || !inputHora) return true;

        const ahora = new Date();
        const fechaSeleccionada = inputFecha.value;
        const horaSeleccionada = inputHora.value;

        if (!fechaSeleccionada || !horaSeleccionada) return false;

        // Crear objeto fecha con la selección (Formato YYYY-MM-DDTHH:mm)
        const seleccion = new Date(`${fechaSeleccionada}T${horaSeleccionada}`);

        if (seleccion < ahora) {
            inputHora.setCustomValidity("La hora no puede ser anterior a la actual");
            inputHora.classList.add('is-invalid');
            return false;
        } else {
            inputHora.setCustomValidity(""); // Esto limpia el error para el navegador
            inputHora.classList.remove('is-invalid');
            inputHora.classList.add('is-valid');
            return true;
        }
    }

    if (inputFecha && inputHora) {
        const hoy = new Date().toISOString().split('T')[0];
        inputFecha.setAttribute('min', hoy);
        
        inputFecha.addEventListener('change', validarFechaHora);
        inputHora.addEventListener('change', validarFechaHora);
        inputHora.addEventListener('input', validarFechaHora);
    }

    // --- 3. INICIALIZACIÓN DE TOMSELECT ---
    const selectModal = document.querySelector('#paciente_id_modal');
    if (selectModal) {
        const searchUrl = selectModal.dataset.url;

        const ts = new TomSelect("#paciente_id_modal", {
            valueField: 'id',
            labelField: 'nombre_completo',
            searchField: ['nombre', 'apellido', 'dni'],
            maxItems: 1,
            load: function(query, callback) {
                if (!query.length) return callback();
                fetch(`${searchUrl}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(json => {
                        callback(json.map(p => ({
                            id: p.id,
                            nombre: p.nombre,
                            apellido: p.apellido,
                            dni: p.dni,
                            nombre_completo: `${p.nombre} ${p.apellido} (DNI: ${p.dni})`
                        })));
                    }).catch(() => callback());
            },
            onChange: function() {
                validarCampo(selectModal); // <--- IMPORTANTE: Validar cuando TomSelect cambia
            },
            render: {
                option: (item, escape) => `<div class="py-2 px-3">
                    <div class="fw-bold"><i class="bi bi-person me-2"></i>${escape(item.nombre)} ${escape(item.apellido)}</div>
                    <div class="small text-muted">Documento: ${escape(item.dni)}</div>
                </div>`,
                item: (item, escape) => `<div>${escape(item.nombre)} ${escape(item.apellido)}</div>`
            }
        });
    }

    // --- 4. LIMPIEZA DE MODAL AL CERRAR ---
    const modalCrear = document.getElementById('modalCrearCita');
    if (modalCrear) {
        modalCrear.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('formCrearCita');
            const selectEl = document.querySelector('#paciente_id_modal');
            
            if (selectEl && selectEl.tomselect) selectEl.tomselect.clear();
            
            form.reset();
            form.classList.remove('was-validated');
            // Quitar clases de validación visual
            form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                el.classList.remove('is-valid', 'is-invalid');
            });
        });
    }

    // --- 5. FUNCIONES GLOBALES ---

    window.abrirModalEditarCita = function(cita) {
        const form = document.getElementById('formEditarCita');
        form.action = `/citas/${cita.id}`;
        form.classList.remove('was-validated'); // Limpiar validaciones previas
        
        document.getElementById('edit_nombre_paciente').value = `${cita.paciente.nombre} ${cita.paciente.apellido}`;
        document.getElementById('edit_fecha').value = cita.fecha;
        document.getElementById('edit_hora').value = cita.hora;
        document.getElementById('edit_estado').value = cita.estado;
        document.getElementById('edit_motivo').value = cita.motivo || '';

        new bootstrap.Modal(document.getElementById('modalEditarCita')).show();
    };

    window.abrirModalVerCita = function(cita) {
        const container = document.getElementById('contenidoVerCita');
        const badgeClass = cita.estado === 'Pendiente' ? 'bg-warning text-dark' : (cita.estado === 'Concluido' ? 'bg-success' : 'bg-danger');
        
        container.innerHTML = `
            <div class="text-center mb-3">
                <span class="badge ${badgeClass} fs-6 px-3">${cita.estado}</span>
            </div>
            <p><strong>Paciente:</strong> ${cita.paciente.nombre} ${cita.paciente.apellido}</p>
            <div class="row">
                <div class="col-6"><p><strong>Fecha:</strong> ${cita.fecha}</p></div>
                <div class="col-6"><p><strong>Hora:</strong> ${cita.hora}</p></div>
            </div>
            <div class="p-3 bg-white border rounded">
                <strong>Motivo:</strong><br>${cita.motivo || 'Sin especificar'}
            </div>
        `;
        new bootstrap.Modal(document.getElementById('modalVerCita')).show();
    };

    window.agendarCitaDesdePaciente = function(id, nombre, apellido, dni) {
        const modalElement = document.getElementById('modalCrearCita');
        const selectEl = document.querySelector('#paciente_id_modal');

        if (selectEl && selectEl.tomselect) {
            const ts = selectEl.tomselect;
            ts.addOption({
                id: id,
                nombre: nombre,
                apellido: apellido,
                dni: dni,
                nombre_completo: `${nombre} ${apellido} (DNI: ${dni})`
            });
            ts.setValue(id);
        }
        new bootstrap.Modal(modalElement).show();
    };
});