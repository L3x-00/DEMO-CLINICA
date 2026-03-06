@extends('layouts.app')

@section('content')
<div class="container py-4">
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

    {{-- TODO LO QUE ESTÉ DENTRO DE ESTE DIV SE IMPRIMIRÁ --}}
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
<script>
    function exportarExcel() {
        // Seleccionamos la tabla específicamente
        const tabla = document.querySelector("table");
        const libro = XLSX.utils.table_to_book(tabla, { sheet: "Reporte Caja" });
        const fecha = new Date().toISOString().slice(0, 10);
        XLSX.writeFile(libro, `Reporte_Caja_${fecha}.xlsx`);
    }

    function imprimirReporte() {
        const contenido = document.getElementById('seccionReporte').innerHTML;
        const ventana = window.open('', '', 'height=800,width=1000');
        
        ventana.document.write('<html><head><title>Reporte de Caja - Clínica</title>');
        ventana.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
        ventana.document.write(`
            <style>
                body { padding: 40px; font-family: 'Segoe UI', sans-serif; background: white !important; color: black !important; }
                .card { border: 1px solid #eee !important; margin-bottom: 20px; box-shadow: none !important; }
                .text-success { color: #28a745 !important; }
                .text-danger { color: #dc3545 !important; }
                .text-primary { color: #007bff !important; }
                th { background-color: #f8f9fa !important; color: black !important; }
                .table-responsive { overflow: visible !important; }
                @media print { .no-print { display: none; } }
            </style>
        `);
        ventana.document.write('</head><body>');
        ventana.document.write('<div class="text-center mb-4">');
        ventana.document.write('<h1 class="fw-bold">CLÍNICA SAN PEDRO</h1>');
        ventana.document.write('<p class="text-muted">Reporte Detallado de Caja</p>');
        ventana.document.write('</div>');
        ventana.document.write(contenido);
        ventana.document.write('<div class="mt-4 small text-center text-muted">Generado el: ' + new Date().toLocaleString() + '</div>');
        ventana.document.write('</body></html>');
        
        ventana.document.close();
        
        // Esperamos a que carguen los estilos antes de imprimir
        ventana.onload = function() {
            setTimeout(() => {
                ventana.print();
                ventana.close();
            }, 500);
        };
    }
</script>
@endpush
@endsection