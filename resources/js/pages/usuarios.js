/**
 * Gestión de Usuarios (Asistentes)
 */

// 1. Función para abrir el modal de edición
window.abrirModalUsuarioEdit = function(id, name, email) {
    const form = document.getElementById('formUsuarioEdit');
    const inputName = document.getElementById('edit_name');
    const inputEmail = document.getElementById('edit_email');

    if (form) {
        // Ajustamos la URL del formulario dinámicamente
        form.action = `/usuarios/${id}`;
        if (inputName) inputName.value = name;
        if (inputEmail) inputEmail.value = email;

        // Limpiamos validaciones previas y campos de password
        form.classList.remove('was-validated');
        form.querySelectorAll('input[type="password"]').forEach(i => i.value = '');

        const modalEl = document.getElementById('modalUsuarioEdit');
        if (modalEl) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    }
};

// 2. Lógica Principal
document.addEventListener("DOMContentLoaded", function() {
    const forms = document.querySelectorAll('.needs-validation');

    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const pass = form.querySelector('input[name="password"]');
            const confirm = form.querySelector('input[name="password_confirmation"]');

            // Validación de coincidencia de contraseñas
            if (pass && confirm && pass.value !== confirm.value) {
                event.preventDefault();
                event.stopPropagation();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Seguridad',
                        text: 'Las contraseñas no coinciden.',
                    });
                }
                confirm.classList.add('is-invalid');
                return;
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
});
// Añade esto a usuarios.js
window.confirmarEliminacion = function(boton) {
    const formulario = boton.closest('.form-eliminar');
    
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¿Eliminar acceso?',
            text: "El usuario ya no podrá ingresar al sistema.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                formulario.submit();
            }
        });
    } else {
        if (confirm('¿Estás seguro de eliminar este usuario?')) {
            formulario.submit();
        }
    }
};
// ... (Funciones anteriores de Edit y ConfirmarEliminacion) ...

// 3. Función para abrir el modal de Ver Detalles
window.abrirModalUsuarioShow = function(name, role, email, createdAt) {
    const showName = document.getElementById('show_name');
    const showRole = document.getElementById('show_role');
    const showEmail = document.getElementById('show_email');
    const showDate = document.getElementById('show_date');

    if (showName) {
        showName.innerText = name;
        showRole.innerText = role;
        showEmail.innerText = email;
        
        // Formatear fecha (YYYY-MM-DD a DD/MM/YYYY)
        const date = new Date(createdAt);
        const formattedDate = date.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        showDate.innerText = formattedDate;

        const modalEl = document.getElementById('modalUsuarioShow');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
};