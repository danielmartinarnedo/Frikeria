
// Cargar scripts de jQuery, Bootstrap y Summernote
function appendScript(src) {
    const script = document.createElement('script');
    script.src = src;
    script.async = false; // Para asegurar que se cargue en orden
    document.body.appendChild(script);
}

appendScript('https://code.jquery.com/jquery-3.6.0.min.js');
appendScript('https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js');
const InputArchivoNombre = document.getElementsByName('nombreArchivo')[0];
confirm(`Cargando Summernote en ${InputArchivoNombre.value}.js`);
appendScript(`../src/${InputArchivoNombre.value}.js`);
InputArchivoNombre.remove();