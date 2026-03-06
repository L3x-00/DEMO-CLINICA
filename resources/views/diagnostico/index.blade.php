@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--bs-body-color);">🩺 Módulo de Diagnóstico</h2>
            <p class="text-muted">Registro integral: Médico, Costos y Comisiones</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDiagnostico">
            <i class="bi bi-plus-circle me-2"></i> Nuevo Registro
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="background-color: var(--card-bg); border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="color: var(--bs-body-color);">
                <thead style="background-color: var(--nav-active-bg);">
                    <tr>
                        <th class="ps-4 py-3 border-0">Paciente</th>
                        <th class="py-3 border-0">Servicio</th>
                        <th class="py-3 border-0">Costo</th>
                        <th class="py-3 border-0">Comisión</th>
                        <th class="py-3 border-0">Jaladora</th>
                        <th class="py-3 border-0 text-end pe-4">Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $s)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">{{ $s->paciente->nombre }}</td>
                        <td><span class="badge bg-info bg-opacity-10 text-info px-3">{{ $s->servicio }}</span></td>
                        <td class="fw-bold text-success">S/. {{ number_format($s->costo, 2) }}</td>
                        <td class="text-danger">S/. {{ number_format($s->comision, 2) }}</td>
                        <td><span class="text-muted small"><i class="bi bi-person me-1"></i>{{ $s->jaladora ?? 'Ninguna' }}</span></td>
                        <td class="text-end pe-4 small text-muted">{{ $s->created_at->format('H:i A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-clipboard-x fs-1 d-block mb-2"></i>
                            No hay registros realizados hoy.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDiagnostico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <div class="modal-content" style="background-color: var(--card-bg); color: var(--bs-body-color); border: none; border-radius: 20px;">
            <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                <h5 class="modal-title fw-bold text-primary"><i class="bi bi-plus-circle-fill me-2"></i>Nuevo Registro Integral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formDiagnostico" action="{{ route('caja.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 border-end border-secondary border-opacity-10">
                            <h6 class="fw-bold mb-3 text-uppercase small opacity-75">Información Médica</h6>
                            
                            <div class="mb-3 position-relative">
                                <label class="form-label small fw-bold">🔎 BUSCAR PACIENTE</label>
                                <input type="text" id="buscarPaciente" class="form-control rounded-3" autocomplete="off" placeholder="Escriba nombre o DNI...">
                                <div id="resultadosBusqueda" class="list-group position-absolute w-100 shadow-lg d-none" style="z-index: 1050;"></div>
                                <input type="hidden" name="paciente_id" id="paciente_id_hidden" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">📦 SERVICIO</label>
                                <select name="servicio" class="form-select rounded-3" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Rayos X">Rayos X 🩻</option>
                                    <option value="Ecografía">Ecografía 🧬</option>
                                    <option value="Traumatología">Traumatología 🦴</option>
                                    <option value="Laboratorio">Laboratorio 🧪</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">📝 OBSERVACIONES</label>
                                <textarea name="observacion" class="form-control rounded-3" rows="3" placeholder="Detalles clínicos relevantes..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4">
                            <h6 class="fw-bold mb-3 text-uppercase small opacity-75">Información de Caja</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-success">💰 COSTO DEL SERVICIO (S/.)</label>
                                <input type="number" step="0.01" name="costo" class="form-control rounded-3 border-success border-opacity-25" placeholder="0.00" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-danger">💸 COMISIÓN (S/.)</label>
                                <input type="number" step="0.01" name="comision" class="form-control rounded-3 border-danger border-opacity-25" placeholder="0.00" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-primary">👤 JALADORA / REFERIDO</label>
                                <input type="text" name="jaladora" class="form-control rounded-3" placeholder="Nombre de quien refiere...">
                            </div>

                            <div class="alert alert-info border-0 rounded-4 small py-2 mt-4">
                                <i class="bi bi-info-circle me-2"></i> Estos datos se reflejarán automáticamente en el Dashboard de Caja.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formDiagnostico" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">Guardar Registro Completo</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // BUSCADOR EN TIEMPO REAL
    document.getElementById('buscarPaciente').addEventListener('input', function() {
        let query = this.value;
        const resultados = document.getElementById('resultadosBusqueda');
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
                                </div>
                            `;
                            item.onclick = () => {
                                document.getElementById('buscarPaciente').value = p.nombre;
                                document.getElementById('paciente_id_hidden').value = p.id;
                                resultados.classList.add('d-none');
                            };
                            resultados.appendChild(item);
                        });
                    }
                });
        } else { resultados.classList.add('d-none'); }
    });

    // Cerrar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!document.getElementById('buscarPaciente').contains(e.target)) {
            document.getElementById('resultadosBusqueda').classList.add('d-none');
        }
    });
</script>
@endpush