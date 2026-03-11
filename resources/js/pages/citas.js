/**
 * Lógica para la creación de Citas
 * Maneja el buscador dinámico de pacientes con TomSelect
 */

document.addEventListener("DOMContentLoaded", function() {
    const selectElement = document.querySelector('#paciente_id');
    
    // Solo inicializamos TomSelect si el elemento existe en el DOM
    if (selectElement && selectElement.tagName === 'SELECT') {
        // Obtenemos la URL de búsqueda desde un atributo data en el HTML para no hardcodearla
        const searchUrl = selectElement.dataset.url;

        new TomSelect("#paciente_id", {
            valueField: 'id',
            labelField: 'nombre_completo',
            searchField: ['nombre', 'apellido', 'dni'],
            maxItems: 1,
            load: function(query, callback) {
                if (!query.length) return callback();
                
                const url = `${searchUrl}?q=${encodeURIComponent(query)}`;
                
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
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/pages/citas.js' // <--- AGREGA ESTA LÍNEA
            ],
            refresh: true,
        }),
    ],
});