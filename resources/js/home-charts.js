document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('ventasChart');
    if (!ctx) return;

    // Recuperamos los datos que pusimos en el HTML
    const etiquetas = JSON.parse(ctx.dataset.etiquetas);
    const valores = JSON.parse(ctx.dataset.valores);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Ingresos Semanales',
                data: valores,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }
    });
});