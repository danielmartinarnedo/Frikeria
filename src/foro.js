document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const idPartida = new URLSearchParams(window.location.search).get("foro");
    const mensajeContendor = document.getElementById("mensajes-container");
    const enviarBoton = document.getElementById("enviar");
    const escribirMensaje = document.getElementById("escribirMensaje");
    const modalReporte = new bootstrap.Modal(document.getElementById('reportModal'));
    const reportarBoton = document.getElementById('reportarBoton');
    const reporteDescripcion = document.getElementById('reporteDescripcion');
    const bloquearBoton = document.getElementById('bloquearBoton');
    const reporteOpcion = document.getElementById('reporteOpcion');
    let nombreParaModal = "";
    let idParaModal;

    // Funciones
    // Funcion para bloquear un usuario
    function bloquear() {
        fetch('../controladores/normal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'bloquearUsuario',
                nombreBloqueado: nombreParaModal
            })
        })
            .then(cargarMensajes())
            .catch(error => console.error('Error:', error));
        modalReporte.hide();
    }
    // Funcion para el reporte de un usuario
    function reportarUsuario() {
        if (reporteDescripcion.value.trim()) {
            fetch('../controladores/normal.php?action=reportarUsuario', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    nombreUsuario: nombreParaModal,
                    descripcion: reporteDescripcion.value
                })
            })
                .catch(error => {
                    console.error('Error al enviar el reporte:', error);
                    alert('Ocurrió un error al enviar el reporte. Por favor, inténtalo de nuevo más tarde.');
                });
            bloquear();
        } else {
            alert('Por favor, ingresa una descripción para el reporte.');
        }

    }
    // Funcion para el reporte de un mensaje
    function reportarMensaje() {
        if (reporteDescripcion.value.trim()) {
            fetch('../controladores/normal.php?action=reportarForo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    idChat: idPartida,
                    idMensaje: idParaModal,
                    descripcion: reporteDescripcion.value
                })
            })
                .catch(error => {
                    console.error('Error al enviar el reporte:', error);
                    alert('Ocurrió un error al enviar el reporte. Por favor, inténtalo de nuevo más tarde.');
                });
            bloquear();
        } else {
            alert('Por favor, ingresa una descripción para el reporte.');
        }

    }
    // Funcion para desbloquear un usuario
    function desbloquear(nombreBloqueado) {
        fetch('../controladores/normal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'desbloquearUsuario',
                nombreBloqueado: nombreBloqueado
            })
        })
            .then(cargarMensajes())
            .catch(error => console.error('Error:', error));
    }
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
            .then(mensajes => {
                mensajeContendor.innerHTML = "";
                mensajes.forEach(mensaje => {
                    let innerRows = "";
                    if (mensaje.bloqueo) {
                        innerRows += `
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-1 d-flex justify-content-end align-items-center">
                    <img class="logoUser" src="${mensaje.usuarioImg}" alt="logo">
                </div>
                <div class="col-11 d-flex justify-items-center align-items-start">
                    <p><span class="me-2">${mensaje.usuarioNom}</span>
                        <svg class="desbloquearUsuario"  data-usuario-nom="${mensaje.usuarioNom}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 bloqueo">
                    ${mensaje.texto}
                </div>
            </div>
        `;
                    } else {
                        if (!mensaje.estado) {
                            if (mensaje.estoyBloqueado) {
                                innerRows += `
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-1 d-flex justify-content-end align-items-center">
                            <img class="logoUser" src="${mensaje.usuarioImg}" alt="logo">
                        </div>
                        <div class="col-11 d-flex justify-items-center align-items-start">
                            <p><span class="me-2">${mensaje.usuarioNom}</span>
                                <svg class="bloqueoReporteUsuario" data-usuario-nom="${mensaje.usuarioNom}" data-mensaje-id="${mensaje.idMensaje}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 24px; height: 24px;">
                                    <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                                </svg>
                            </p>
                        </div>
                    </div>
                `;
                            } else {
                                innerRows += `
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-1 d-flex justify-content-end align-items-center">
                            <img class="logoUser" src="${mensaje.usuarioImg}" alt="logo">
                        </div>
                        <div class="col-11 d-flex justify-items-center align-items-start">
                            <p><span class="me-2">${mensaje.usuarioNom}</span>
                                <a href="../controladores/normal.php?action=irChatPrivado&usuarioNom=${encodeURIComponent(mensaje.usuarioNom)}" title="Chat privado">
                                    <svg class="me-1 envarMensajeUsu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 24px; height: 24px;">
                                        <path d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480l0-83.6c0-4 1.5-7.8 4.2-10.8L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z"/>
                                    </svg>
                                </a>
                                <svg class="bloqueoReporteUsuario" data-usuario-nom="${mensaje.usuarioNom}" data-mensaje-id="${mensaje.idMensaje}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 24px; height: 24px;">
                                    <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                                </svg>
                            </p>
                        </div>
                    </div>
                `;
                            }
                        } else {
                            innerRows += `
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-1 d-flex justify-content-end align-items-center">
                        <img class="logoUser" src="${mensaje.usuarioImg}" alt="logo">
                    </div>
                    <div class="col-11 d-flex justify-items-center align-items-start">
                        <p><span class="me-2">${mensaje.usuarioNom}</span></p>
                    </div>
                </div>
            `;
                        }
                        innerRows += `
            <div class="row">
                <div class="col-12">
                    ${mensaje.texto}
                </div>
            </div>
        `;
                    }

                    mensajeContendor.innerHTML += `<div class="container">${innerRows}</div>`;
                });

                const bloqueoReporteUsuario = document.querySelectorAll(".bloqueoReporteUsuario");
                bloqueoReporteUsuario.forEach(function (bloqueo) {
                    bloqueo.addEventListener("click", function () {
                        nombreParaModal = this.getAttribute("data-usuario-nom");
                        idParaModal = this.getAttribute("data-mensaje-id");
                        modalReporte.show();
                    });
                });

                const desbloquearUsuario = document.querySelectorAll(".desbloquearUsuario");
                desbloquearUsuario.forEach(function (desbloqueo) {
                    desbloqueo.addEventListener("click", function () {
                        const usuarioNom = this.getAttribute("data-usuario-nom");
                        desbloquear(usuarioNom);
                    });
                });
            })
            .catch(error => console.error('Error:', error));
    }
    function enviarMensaje(texto) {
        fetch('../controladores/normal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'crearMensajeForo',
                texto: texto,
                id: idPartida
            })
        })
            .then(cargarMensajes())
            .catch(error => console.error('Error:', error));
    }

    // Codigo General
    cargarMensajes();

    // Enviar mensaje al hacer clic en el botón
    enviarBoton.addEventListener("click", function (e) {
        e.preventDefault();
        enviarMensaje($(escribirMensaje).summernote('code').trim());
        $(escribirMensaje).summernote('reset');
    });

    //Bloquea al usuario
    bloquearBoton.addEventListener("click", function (e) {
        bloquear(nombreParaModal);
    })
    // Reportar usuario
    reportarBoton.addEventListener('click', () => {
        if (reporteOpcion.value === "usuario") {
            reportarUsuario();
        } else {
            reportarMensaje();
        }
        
    });
    // Actualizar mensajes cada 5 segundos
    setInterval(cargarMensajes, 5000);

    $(escribirMensaje).summernote({
        height: 250,
        lang: 'es-ES',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph', 'table']],
            ['insert', ['link', 'video']],
            ['view', ['fullscreen', 'help']]
        ]
    });
});