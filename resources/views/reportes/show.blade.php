@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    {{-- Botones de acción (No se imprimen) --}}
    <div class="d-print-none mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <button onclick="window.print();" class="btn btn-primary btn-lg shadow">
            <i class="bi bi-printer-fill me-2"></i> Imprimir Informe
        </button>
    </div>

    {{-- HOJA CLÍNICA PROFESIONAL --}}
    <div class="report-paper mx-auto shadow-lg">
        
        {{-- Encabezado con el Logo/Especialidad --}}
        <div class="header-section">
            <div class="text-end">
                <h5 class="specialty-title">Traumatología Y Ortopedia</h5>
            </div>
            <div class="text-center mt-4">
                <h4 class="report-main-title">INFORME MEDICO</h4>
            </div>
        </div>

        {{-- Datos del Paciente --}}
        <div class="patient-data-section mt-5">
            <div class="row mb-3">
                <div class="col-12 border-dotted-bottom">
                    <span class="label">Nombres y Apellidos:</span>
                    <span class="data-value">{{ $reporte->paciente->nombre }} {{ $reporte->paciente->apellido }}</span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6 border-dotted-bottom">
                    <span class="label">Edad:</span>
                    <span class="data-value">{{ \Carbon\Carbon::parse($reporte->paciente->fecha_nacimiento)->age }} años</span>
                </div>
                <div class="col-6 border-dotted-bottom text-end">
                    <span class="label">DNI:</span>
                    <span class="data-value">{{ $reporte->paciente->dni }}</span>
                </div>
            </div>
        </div>

        {{-- Cuerpo del Informe con líneas punteadas para simular el formato físico --}}
        {{-- Resumen de Historia Clínica --}}
        <div class="info-block mt-3">
            <h6 class="field-title">Resumen de Historia Clínica</h6>
            <div class="content-text border-dotted-full fw-bold text-danger">
                {{-- Aquí mostramos el dato de alergias del paciente --}}
                {{ $reporte->paciente->alergias ?? 'Ninguna conocida.' }}
            </div>
        </div>
        <div class="report-body">
            <div class="info-block">
                <h6 class="field-title">Exámen Físico Preferencial</h6>
                <div class="content-text border-dotted-full">
                    {{ $reporte->examen_fisico_preferencial ?: 'S.D.N.' }}
                </div>
            </div>

            <div class="info-block">
                <h6 class="field-title">Exámenes Auxiliares</h6>
                <div class="content-text border-dotted-full">
                    {{ $reporte->examen_auxiliar ?: 'Ninguno registrado.' }}
                </div>
            </div>

            <div class="info-block">
                <h6 class="field-title">Tratamiento</h6>
                <div class="content-text border-dotted-full">
                    {{ $reporte->tratamiento ?: 'No especificado.' }}
                </div>
            </div>

            <div class="row info-block align-items-end">
                <div class="col-9">
                    <h6 class="field-title">Diagnóstico</h6>
                    <div class="content-text border-dotted-bottom fw-bold">
                        {{ $reporte->diagnostico }}
                    </div>
                </div>
                <div class="col-3 text-end">
                    <h6 class="field-title text-center">CIE 10</h6>
                    <div class="content-text border-dotted-bottom text-center">
                        {{ $reporte->cie_10 ?: '---' }}
                    </div>
                </div>
            </div>

            <div class="info-block">
                <h6 class="field-title">Evolución</h6>
                <div class="content-text border-dotted-full">
                    {{ $reporte->evolucion ?: 'Estable.' }}
                </div>
            </div>

            <div class="info-block">
                <h6 class="field-title">Recomendaciones</h6>
                <div class="content-text border-dotted-full">
                    {{ $reporte->recomendaciones ?: 'Seguir indicaciones médicas.' }}
                </div>
            </div>
        </div>

        {{-- Pie de página: Fecha y Firma --}}
        <div class="footer-section mt-5 pt-5">
            <div class="row align-items-end">
                <div class="col-5 border-dotted-bottom text-center">
                    <span class="label">Fecha:</span>
                    <span class="data-value">{{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}</span>
                </div>
                <div class="col-2"></div>
                <div class="col-5 border-dotted-top text-center pt-2">
                    <span class="data-value d-block">Dr. {{ $reporte->doctor }}</span>
                    <span class="label small">Traumatólogo y Ortopedista</span>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
@endpush
@endsection