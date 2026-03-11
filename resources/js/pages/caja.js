/**
 * Lógica para el Dashboard de Caja
 * Maneja la exportación a Excel y la generación de reportes impresos.
 */

// Exportamos las funciones al objeto global 'window' para que sigan siendo 
// accesibles desde los atributos 'onclick' del HTML.

window.exportarExcel = function() {
    const tabla = document.querySelector("table");
    if (!tabla) return;

    const libro = XLSX.utils.table_to_book(tabla, { sheet: "Reporte Caja" });
    const fecha = new Date().toISOString().slice(0, 10);
    XLSX.writeFile(libro, `Reporte_Caja_${fecha}.xlsx`);
}

window.imprimirReporte = function() {
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
    
    ventana.onload = function() {
        setTimeout(() => {
            ventana.print();
            ventana.close();
        }, 500);
    };
}
