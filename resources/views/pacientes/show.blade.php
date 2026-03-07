@extends('layouts.app')

@section('content')
<div class="container pb-5 mt-4">
    {{-- BARRA DE ACCIONES SUPERIOR --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm w-fit">
            <i class="bi bi-arrow-left me-1"></i> Volver al Listado
        </a>
        <a href="{{ route('reportes.create', ['paciente_id' => $paciente->id]) }}" class="btn btn-success shadow-sm">
            <i class="bi bi-file-earmark-plus"></i> Generar Informe Médico
        </a>
        {{-- Contenedor de botones adaptado --}}
        <div class="d-flex gap-2 shadow-sm p-1 bg-body-tertiary rounded border">
            <button onclick="window.print();" class="btn btn-outline-secondary btn-sm border-0">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
            <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-warning btn-sm text-dark px-3 fw-bold">
                <i class="bi bi-pencil-square me-1"></i> Editar
            </a>
            <a href="{{ route('citas.create', ['paciente_id' => $paciente->id]) }}" class="btn btn-primary btn-sm px-3 fw-bold">
                <i class="bi bi-calendar-plus me-1"></i> Agendar Cita
            </a>
            
        </div>
    </div>

    {{-- TARJETA MAESTRA --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-card-custom">
        {{-- HEADER: PERFIL DESTACADO --}}
        <div class="card-header custom-profile-header py-4 px-4">
            <div class="row align-items-center">
                <div class="col-md-auto mb-3 mb-md-0 text-center">
                    <div class="profile-icon-wrapper shadow-sm">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                </div>

                <div class="col-md text-center text-md-start">
                    <h2 class="profile-title mb-1 fw-bold">
                        {{ $paciente->apellido }}, {{ $paciente->nombre }}
                    </h2>
                    <div class="profile-info-badges d-flex flex-wrap justify-content-center justify-content-md-start gap-3 small">
                        <span><i class="bi bi-card-text"></i> {{ $paciente->tipo_documento ?? 'DNI' }}: {{ $paciente->dni }}</span>
                        <span><i class="bi bi-calendar3"></i> {{ $paciente->edad }} años</span>
                        <span><i class="bi bi-clock-history"></i> {{ $paciente->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="col-md-auto text-end mt-3 mt-md-0">
                    <span class="badge-gender {{ $paciente->sexo == 'Masculino' ? 'gender-male' : 'gender-female' }}">
                        <i class="bi bi-gender-ambiguous me-1"></i> {{ $paciente->sexo }}
                    </span>
                </div>
            </div>
        </div>

        {{-- CUERPO PRINCIPAL --}}
        <div class="card-body p-4">
            <div class="row g-4">
                
                {{-- COLUMNA IZQUIERDA --}}
                <div class="col-lg-8">
                    {{-- SECCIÓN: MOTIVO --}}
                    <div class="alert {{ $paciente->alergias ? 'alert-danger' : 'bg-body-secondary border' }} border-start border-4 mb-4 shadow-sm">
                        <h6 class="alert-heading fw-bold"><i class="bi bi-exclamation-octagon-fill me-2"></i>Motivo de la consulta</h6>
                        <p class="mb-0 fs-5 fw-medium text-body-emphasis">
                            {{ $paciente->alergias ?? 'No reporta alergias conocidas.' }}
                        </p>
                    </div>
<button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDiagnostico">
            <i class="bi bi-plus-circle me-2"></i> Nuevo Registro
        </button>
                    <div class="row g-4">
                        {{-- Bloque: Información Personal --}}
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body-secondary small fw-bold mb-3 ls-1">Información de Origen</h6>
                            <ul class="list-group list-group-flush border-top small">
                                <li class="list-group-item d-flex justify-content-between px-0 py-2 bg-transparent">
                                    <span class="text-body-secondary">Fecha Nacimiento:</span>
                                    <span class="fw-bold text-body-emphasis">{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') : '---' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0 py-2 bg-transparent">
                                    <span class="text-body-secondary">Nacionalidad:</span>
                                    <span class="text-body-emphasis">{{ $paciente->nacionalidad ?? '---' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Bloque: Contacto --}}
                    <div class="mt-4 p-3 border rounded-3 bg-body-tertiary shadow-sm">
                        <div class="row align-items-center text-center text-md-start">
                            <div class="col-md-6 mb-2 mb-md-0 border-end-md">
                                <span class="text-body-secondary small d-block">WhatsApp / Teléfono</span>
                                <span class="fs-5 fw-bold text-success"><i class="bi bi-whatsapp"></i> {{ $paciente->telefono ?? '---' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN DE EVIDENCIA --}}
                    <div class="card border-0 shadow-sm rounded-4 mt-4 bg-body-secondary">
                        <div class="card-body">
                            <h6 class="fw-bold text-body-emphasis mb-3 text-uppercase small ls-1"><i class="bi bi-image me-2 text-primary"></i>Evidencia Médica</h6>
                            @if($paciente->evidencia)
                                <div class="evidencia-container">
                                    <img src="{{ asset('storage/' . $paciente->evidencia) }}" 
                                         class="img-fluid rounded-3 border shadow-sm" 
                                         alt="Evidencia del paciente">
                                </div>
                            @else
                                <div class="bg-body-tertiary rounded-3 p-5 text-center text-body-secondary border-dashed shadow-sm">
                                    <i class="bi bi-image-fill fs-1 d-block mb-2 opacity-50"></i>
                                    Sin evidencia fotográfica registrada.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA --}}
                <div class="col-lg-4">
                    <div class="card bg-body-tertiary border-0 rounded-3 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="mt-4">
                                <div class="alert alert-info bg-info-subtle border-0 small mb-0 shadow-sm text-info-emphasis">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Esta ficha contiene información sensible y está protegida por normativa.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- FOOTER CON BOTÓN ELIMINAR --}}
        <div class="card-footer bg-body-tertiary border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-body-secondary small">Última actualización: {{ $paciente->updated_at->diffForHumans() }}</span>
                
                <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" onsubmit="return confirm('¿Está COMPLETAMENTE seguro de eliminar esta historia clínica?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger btn-sm text-decoration-none fw-bold">
                        <i class="bi bi-trash3 me-1"></i> Eliminar Registro
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
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
@endsection