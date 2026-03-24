<div class="modal fade" id="modalUsuarioCreate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; background-color: var(--card-bg);">
            <div class="modal-header border-0 py-4" style="background-color: var(--nav-active-bg);">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                        <i class="bi bi-person-plus-fill fs-4 text-primary"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" style="color: var(--accent-main);">Registrar Nuevo Asistente</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('usuarios.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small opacity-75">NOMBRES</label>
                            <input type="text" name="name" class="form-control custom-input" placeholder="Ej. Juan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small opacity-75">APELLIDOS</label>
                            <input type="text" name="apellidos" class="form-control custom-input" placeholder="Ej. Pérez" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small opacity-75">CORREO ELECTRÓNICO LABORAL</label>
                            <input type="email" name="email" class="form-control custom-input" placeholder="asistente@clinica.com" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small opacity-75">ROL DEL USUARIO</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-shield-check"></i></span>
                                <select name="role" class="form-select border-start-0 custom-input" required>
                                    <option value="" selected disabled>Seleccione un rol...</option>
                                    <option value="asistente">Asistente</option>
                                    <option value="doctor">Doctor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small opacity-75">CONTRASEÑA</label>
                            <input type="password" name="password" class="form-control custom-input" required minlength="8">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small opacity-75">CONFIRMAR CONTRASEÑA</label>
                            <input type="password" name="password_confirmation" class="form-control custom-input" required minlength="8">
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-muted small mb-4"><i class="bi bi-info-circle me-1"></i> El usuario tendrá el rol de <strong>Asistente</strong>.</p>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-shield-lock me-2"></i> Crear Credenciales
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUsuarioEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; background-color: var(--card-bg);">
            <div class="modal-header border-0 py-4" style="background-color: var(--nav-active-bg);">
                <h5 class="modal-title fw-bold mb-0">Actualizar Credenciales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formUsuarioEdit" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small opacity-75">NOMBRE COMPLETO</label>
                        <input type="text" name="name" id="edit_name" class="form-control custom-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small opacity-75">CORREO ELECTRÓNICO</label>
                        <input type="email" name="email" id="edit_email" class="form-control custom-input" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold small opacity-75">ROL DEL USUARIO</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-shield-check"></i></span>
                            <select name="role" class="form-select border-start-0 custom-input" required>
                                <option value="" selected disabled>Seleccione un rol...</option>
                                <option value="asistente">Asistente</option>
                                <option value="doctor">Doctor</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                            <div class="alert alert-warning border-0 small rounded-3 py-2">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Deje la clave en blanco si no desea cambiarla.
                            </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small opacity-75">NUEVA CLAVE</label>
                            <input type="password" name="password" class="form-control custom-input" placeholder="••••••••">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small opacity-75">CONFIRMAR CLAVE</label>
                            <input type="password" name="password_confirmation" class="form-control custom-input" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">
                            Actualizar Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalUsuarioShow" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; background-color: var(--card-bg);">
            <div class="modal-body text-center p-5 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-block p-4 mb-4">
                    <i class="bi bi-person-vcard fs-1"></i>
                </div>
                
                <h3 class="fw-bold mb-1" id="show_name" style="color: var(--bs-body-color);"></h3>
                <span id="show_role" class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-4 mb-4 text-uppercase"></span>

                <div class="text-start mt-4 p-4 rounded" style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                    <div class="mb-3 border-bottom pb-2" style="border-color: var(--bs-border-color) !important;">
                        <small class="text-muted d-block small fw-bold text-uppercase">Correo Electrónico</small>
                        <span class="fw-bold" id="show_email" style="color: var(--bs-body-color);"></span>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block small fw-bold text-uppercase">Fecha de Registro</small>
                        <span class="fw-bold" id="show_date" style="color: var(--bs-body-color);"></span>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-5" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>