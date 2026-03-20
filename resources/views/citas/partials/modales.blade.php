<div class="modal fade" id="modalCrearCita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Programar Nueva Cita 🩺</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('citas.store') }}" method="POST" id="formCrearCita" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Paciente</label>
                        <select name="paciente_id" id="paciente_id_modal" class="form-control" 
                                data-url="{{ url('buscar-pacientes') }}" required>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione un paciente.</div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Fecha</label>
                            <input type="date" name="fecha" id="fecha_crear" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                            <div class="invalid-feedback">La fecha no puede ser anterior a hoy.</div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Hora</label>
                            <input type="time" name="hora" id="hora_crear" class="form-control" required>
                            <div class="invalid-feedback">Seleccione una hora válida.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Motivo</label>
                        <textarea name="motivo" class="form-control" rows="2" required minlength="5"></textarea>
                        <div class="invalid-feedback">El motivo debe tener al menos 5 caracteres.</div>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-success" id="btnGuardarCita">Guardar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarCita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold">Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCita" method="POST" novalidate>
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Paciente</label>
                        <input type="text" id="edit_nombre_paciente" class="form-control bg-light" readonly>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="edit_fecha" class="form-control border-warning" required>
                            <div class="invalid-feedback">Fecha obligatoria.</div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Hora</label>
                            <input type="time" name="hora" id="edit_hora" class="form-control border-warning" required>
                            <div class="invalid-feedback">Hora obligatoria.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" id="edit_estado" class="form-select border-warning" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Concluido">Concluido</option>
                            <option value="No presentado">No presentado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <textarea name="motivo" id="edit_motivo" class="form-control border-warning" rows="2" required minlength="5"></textarea>
                        <div class="invalid-feedback">El motivo es muy corto.</div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Actualizar Cita</button>
                </form>
            </div>
        </div>
    </div>
</div>