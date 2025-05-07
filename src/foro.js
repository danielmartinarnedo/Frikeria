document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const idPartida = new URLSearchParams(window.location.search).get("foro");
    console.log(idPartida);
    const mensajeContendor = document.getElementById("mensajes-container");

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
            .then(response => response.text()) // Keep as .text() for debugging
            .then(data => {
                console.log('Raw Response:', data); // Log the raw response
                return JSON.parse(data); // Parse the JSON
            })
            .then(mensajes => {
                mensajes.forEach(mensaje => {
                    mensajeContendor.innerHTML += `<div class="container">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-1 d-flex justify-content-end align-items-center">
                            <img class="logoUser" src="${mensaje.usuarioImg}" alt="logo">
                        </div>
                        <div class="col-11 d-flex justify-items-center align-items-start">
                            <p><span class="me-2">${mensaje.usuarioNom}</span>
                                <svg class="me-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 24px; height: 24px;">
                                    <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 24px; height: 24px;">
                                    <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                                </svg>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            ${mensaje.texto}
                        </div>
                    </div>
                </div>`;
                });
            })
            .catch(error => console.error('Error:', error));
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