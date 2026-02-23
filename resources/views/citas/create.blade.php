@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">Programar Nueva Cita Traumatológica 🩺</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('citas.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="paciente_id" class="form-label fw-bold">Paciente</label>
                            
                            @if($pacientePreseleccionado)
                                {{-- Vista cuando ya seleccionamos al paciente desde su ficha --}}
                                <div class="alert alert-info border-0 shadow-sm d-flex justify-content-between align-items-center mb-1">
                                    <span>
                                        <i class="bi bi-person-check-fill me-2"></i>
                                        <strong>{{ $pacientePreseleccionado->nombre }} {{ $pacientePreseleccionado->apellido }}</strong>
                                        <span class="badge bg-white text-primary ms-2">DNI: {{ $pacientePreseleccionado->dni }}</span>
                                    </span>
                                    <a href="{{ route('citas.create') }}" class="btn btn-sm btn-outline-primary">Cambiar</a>
                                </div>
                                <input type="hidden" name="paciente_id" value="{{ $pacientePreseleccionado->id }}">
                                <small class="text-muted">Se agendará la cita para el paciente arriba indicado.</small>
                            @else
                                {{-- Buscador TomSelect para citas generales --}}
                                <select name="paciente_id" id="paciente_id" class="form-control" placeholder="Escriba nombre o DNI del paciente..." required></select>
                                <div id="paciente-error" class="text-danger small mt-1"></div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fecha 📅</label>
                                <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Hora ⏰</label>
                                <input type="time" name="hora" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Motivo de la consulta 🦴</label>
                            <textarea name="motivo" class="form-control" rows="3" placeholder="Ej: Evaluación de fractura, dolor crónico, etc..." required></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Guardar Cita
                            </button>
                            <a href="{{ route('citas.index') }}" class="btn btn-light border">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const selectElement = document.querySelector('#paciente_id');
    
    // Solo inicializamos TomSelect si el elemento existe (no está preseleccionado)
    if (selectElement && selectElement.tagName === 'SELECT') {
        new TomSelect("#paciente_id", {
            valueField: 'id',
            labelField: 'nombre_completo',
            searchField: ['nombre', 'apellido', 'dni'],
            maxItems: 1,
            load: function(query, callback) {
                if (!query.length) return callback();
                
                const url = "{{ url('buscar-pacientes') }}?q=" + encodeURIComponent(query);
                
                fetch(url)
                    .then(response => response.json())
                    .then(json => {
                        const results = json.map(p => ({
                            id: p.id,
                            nombre: p.nombre,
                            apellido: p.apellido,
                            dni: p.dni,
                            nombre_completo: `${p.nombre} ${p.apellido} (DNI: ${p.dni})`
                        }));
                        callback(results);
                    })
                    .catch(() => callback());
            },
            render: {
                option: function(item, escape) {
                    return `<div class="py-2 px-3">
                                <div class="fw-bold"><i class="bi bi-person me-2"></i>${escape(item.nombre)} ${escape(item.apellido)}</div>
                                <div class="small text-muted">Documento: ${escape(item.dni)}</div>
                            </div>`;
                },
                item: function(item, escape) {
                    return `<div>${escape(item.nombre)} ${escape(item.apellido)}</div>`;
                }
            }
        });
    }
});
</script>
@endsection