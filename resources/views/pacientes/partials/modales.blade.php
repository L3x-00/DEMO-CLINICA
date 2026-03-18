{{-- MODAL DE REGISTRO INTEGRAL (DIAGNÓSTICO) --}}
<div class="modal fade" id="modalDiagnostico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            {{-- Header suave --}}
            <div class="modal-header border-0 pt-4 px-4 pb-2">
                <div>
                    <h5 class="modal-title fw-bold text-primary-emphasis mb-0">Nuevo Registro Integral</h5>
                    <p class="text-muted small mb-0">Complete la información médica y de caja para el paciente.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <form id="formDiagnostico" action="{{ route('caja.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="paciente_id" id="paciente_id_hidden" required>
                    
                    {{-- Banner de Paciente --}}
                    <div class="d-flex align-items-center p-3 mb-4 rounded-3 bg-light border">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bi bi-person-vcard fs-4 text-primary"></i>
                        </div>
                        <div>
                            <div id="nombrePacienteDisplay" class="fw-bold text-dark fs-6">-</div>
                            <div id="dniPacienteDisplay" class="text-muted small">DNI: -</div>
                        </div>
                    </div>

                    <div class="row g-4">
                        {{-- Columna Médica --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Detalles Médicos</label>
                            
                            <div class="mb-3">
                                <label class="form-label small text-muted">Servicio solicitado</label>
                                <select name="servicio" class="form-select border-light-subtle bg-light shadow-sm" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Rayos X">Rayos X</option>
                                    <option value="Ecografía">Ecografía</option>
                                    <option value="Traumatología">Traumatología</option>
                                    <option value="Laboratorio">Laboratorio</option>
                                </select>
                            </div>

                            <div class="mb-0">
                                <label class="form-label small text-muted">Observaciones generales</label>
                                <textarea name="observacion" class="form-control border-light-subtle bg-light shadow-sm" rows="4" placeholder="Notas sobre el procedimiento..."></textarea>
                            </div>
                        </div>

                        {{-- Columna Financiera --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Información de Caja</label>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small text-muted">Costo (S/.)</label>
                                    <input type="number" step="0.01" name="costo" class="form-control border-light-subtle bg-light shadow-sm" required placeholder="0.00">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small text-muted">Comisión (S/.)</label>
                                    <input type="number" step="0.01" name="comision" class="form-control border-light-subtle bg-light shadow-sm" required placeholder="0.00">
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label small text-muted">Referido por / Jaladora</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-person-badge text-muted"></i></span>
                                    <input type="text" name="jaladora" class="form-control border-light-subtle bg-light" placeholder="Nombre del referido">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="formDiagnostico" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow">
                    Guardar Registro
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DE DERIVACIÓN --}}
<div class="modal fade" id="modalDerivacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4 pb-0">
                <h5 class="modal-title fw-bold text-dark">Derivación de Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('atenciones.derivar') }}" method="POST" id="formDerivacion">
                @csrf
                <input type="hidden" name="paciente_id" id="derivar_paciente_id">
                
                <div class="modal-body p-4">
                    <p class="text-muted mb-4 small">Está enviando a <strong id="nombrePacienteDerivar" class="text-primary"></strong> a un nuevo servicio.</p>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Destino del Paciente</label>
                        <select name="servicio" class="form-select py-2 border-light-subtle bg-light shadow-sm" id="selectServicio" onchange="cambiarMontoSugerido()" required>
                            <option value="Consulta Médica" data-monto="100">Consulta Médica (Dr. Yuri)</option>
                            <option value="Tomografía" data-monto="250">Tomografía</option>
                            <option value="Rayos X" data-monto="80">Rayos X</option>
                            <option value="Otros" data-monto="0">Otro Servicio</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-secondary">Monto a Cobrar (S/)</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-light-subtle fw-bold">S/</span>
                            <input type="number" name="total_pagado" id="monto_atencion" class="form-control py-2 border-light-subtle bg-light" value="100" step="0.01" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold shadow">
                        Confirmar Envío
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>