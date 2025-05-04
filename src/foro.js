document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const idPartida = new URLSearchParams(window.location.search).get("foro");
    console.log(idPartida);

    // Funciones
    function cargarMensajes() {
        fetch('../controladores/normal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'buscarMensajes',
                id: idPartida
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log(JSON.parse(data));
            })
    }
    function enviarMensaje() {
        const mensaje = document.getElementById("mensaje").value;
        fetch('../controladores/normal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'enviarMensaje',
                id: idPartida,
                mensaje: mensaje
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                cargarMensajes();
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Codigo General
    cargarMensajes();
});