@extends('layouts.app')

@section('content')
{{-- Usamos un div con padding pero sin .container para que no choque con la sidebar --}}
<div class="px-2 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--bs-body-color);">💰 Dashboard de Caja</h2>
            <p class="text-muted">Resumen de ingresos y egresos del turno</p>
        </div>
        
        <div class="d-flex gap-2">
            <form action="{{ route('caja.index') }}" method="GET" class="d-flex gap-2">
                <select name="periodo" onchange="this.form.submit()" class="form-select rounded-pill shadow-sm">
                    <option value="hoy" {{ $filtro == 'hoy' ? 'selected' : '' }}>Hoy</option>
                    <option value="semana" {{ $filtro == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                    <option value="mes" {{ $filtro == 'mes' ? 'selected' : '' }}>Este Mes</option>
                </select>
            </form>
        </div>
    </div>

    {{-- BOTONES DE EXPORTACIÓN --}}
    <div class="d-flex justify-content-end gap-2 mb-3">
        <button onclick="exportarExcel()" class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Excel
        </button>
        <button onclick="imprimirReporte()" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-file-earmark-pdf me-1"></i> Imprimir / PDF
        </button>
    </div>

    {{-- SECCIÓN DE REPORTE --}}
    <div id="seccionReporte">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 text-center" style="background-color: var(--card-bg); border-bottom: 4px solid #28a745 !important;">
                    <span class="text-muted small fw-bold">TOTAL INGRESOS</span>
                    <h2 class="text-success fw-bold">S/. {{ number_format($ingresoBruto, 2) }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 text-center" style="background-color: var(--card-bg); border-bottom: 4px solid #dc3545 !important;">
                    <span class="text-muted small fw-bold">TOTAL COMISIONES</span>
                    <h2 class="text-danger fw-bold">S/. {{ number_format($totalComisiones, 2) }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 text-center" style="background-color: var(--card-bg); border-bottom: 4px solid #007bff !important;">
                    <span class="text-muted small fw-bold">UTILIDAD NETA</span>
                    <h2 class="text-primary fw-bold">S/. {{ number_format($utilidadNeta, 2) }}</h2>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="background-color: var(--card-bg); border-radius: 15px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="color: var(--bs-body-color);">
                    <thead style="background-color: var(--nav-active-bg);">
                        <tr>
                            <th class="ps-4 py-3">Paciente</th>
                            <th>Servicio</th>
                            <th>Observación</th>
                            <th class="text-center">Costo</th>
                            <th class="text-center">Comisión</th>
                            <th>Jaladora</th>
                            <th class="text-end pe-4">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servicios as $s)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $s->paciente->nombre }}</td>
                            <td>{{ $s->servicio }}</td>
                            <td class="small text-muted">{{ Str::limit($s->observacion, 30) }}</td>
                            <td class="text-center fw-bold">S/. {{ number_format($s->costo, 2) }}</td>
                            <td class="text-center text-danger">S/. {{ number_format($s->comision, 2) }}</td>
                            <td>{{ $s->jaladora ?? '-' }}</td>
                            <td class="text-end pe-4 small text-muted">{{ $s->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
{{-- Vite cargará caja.js automáticamente si está en tu vite.config.js y app.js --}}
@endpush
@endsection