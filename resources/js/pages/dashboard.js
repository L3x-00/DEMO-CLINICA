import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", function () {
    // 1. Gráfico de Dona
    const canvasHoy = document.getElementById('chartAtencionHoy');
    if (canvasHoy) {
        new Chart(canvasHoy, {
            type: 'doughnut',
            data: {
                labels: ['Atendidos', 'Pendientes'],
                datasets: [{
                    // Usamos Number() para asegurar que Chart.js reciba valores numéricos
                    data: [
                        Number(canvasHoy.dataset.atendidos), 
                        Number(canvasHoy.dataset.pendientes)
                    ],
                    backgroundColor: ['#198754', '#e9ecef'],
                    borderWidth: 0,
                    spacing: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: { 
                    legend: { 
                        position: 'bottom', 
                        labels: { usePointStyle: true, padding: 20 } 
                    } 
                }
            }
        });
    }

    // 2. Gráfico de Barras
    const canvasComp = document.getElementById('chartComparativoAtencion');
    if (canvasComp) {
        new Chart(canvasComp, {
            type: 'bar',
            data: {
                labels: ['Ayer', 'Hoy'],
                datasets: [{
                    data: [
                        Number(canvasComp.dataset.ayer), 
                        Number(canvasComp.dataset.hoy)
                    ],
                    backgroundColor: ['#6c757d33', '#0d6efd'],
                    borderRadius: 12,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1, precision: 0 } // precision: 0 para no mostrar decimales en conteo de personas
                    }
                }
            }
        });
    }

    // 3. Modal de Reprogramación (Limpio y funcional)
    const modalReprogramar = document.getElementById('modalReprogramar');
    if (modalReprogramar) {
        modalReprogramar.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const form = document.getElementById('formReprogramar');
            
            // Seteamos la ruta dinámicamente
            const citaId = button.getAttribute('data-cita-id');
            form.action = `/citas/${citaId}/reprogramar`;
            
            // Seteamos el nombre del paciente en el modal
            const nombrePaciente = button.getAttribute('data-paciente');
            document.getElementById('nombrePacienteModal').textContent = nombrePaciente;
        });
    }
});