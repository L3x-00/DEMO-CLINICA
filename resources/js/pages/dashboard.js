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
                    data: [canvasHoy.dataset.atendidos, canvasHoy.dataset.pendientes],
                    backgroundColor: ['#198754', '#e9ecef'],
                    borderWidth: 0,
                    spacing: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } }
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
                    data: [canvasComp.dataset.ayer, canvasComp.dataset.hoy],
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
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    }

    // 3. Modal de Reprogramación
    const modalReprogramar = document.getElementById('modalReprogramar');
    if (modalReprogramar) {
        modalReprogramar.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const form = document.getElementById('formReprogramar');
            form.action = `/citas/${button.getAttribute('data-cita-id')}/reprogramar`;
            document.getElementById('nombrePacienteModal').textContent = button.getAttribute('data-paciente');
        });
    }
});