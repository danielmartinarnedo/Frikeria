document.addEventListener('DOMContentLoaded', function () {
    const mensajeContendor = document.getElementById("mensajes-container");
    const reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
    const quitarTicket = document.querySelector('.btn-success');
    const quitarMensaje = document.getElementById('quitarMensaje');
    const quitarUsuario = document.getElementById('quitarUsuario');

    const getPostDatos = document.querySelectorAll('input[type="hidden"]')
    const datos = {};
    getPostDatos.forEach(input => {
        datos[input.name] = input.value;
        input.remove();
    });
    let datosReporte = {};

    // Separa chat_* y otras claves
    const mensajes = [];
    const datosIniciales = {};

    Object.keys(datos).forEach(key => {
        if (key.startsWith("chat_")) {
            try {
                mensajes.push(JSON.parse(datos[key]));
            } catch (e) {
                // Ignora si no es un JSON
            }
        } else {
            datosIniciales[key] = datos[key];
        }
    });

    mensajes.forEach((mensaje, index) => {
        console.log(mensaje);
        // Crea el contenedor del mensaje
        const mensajeRow = document.createElement('div');
        mensajeRow.id = `mensaje${mensaje["idMensaje"]}`;
        mensajeRow.className = "row d-flex justify-content-center align-items-center";

        // Imagen
        const colImg = document.createElement('div');
        colImg.className = "col-1 d-flex justify-content-end align-items-center";
        const img = document.createElement('img');
        img.className = "logoUser";
        img.src = mensaje.usuarioImg;
        img.alt = "logo";
        colImg.appendChild(img);

        // Nombre
        const colInfo = document.createElement('div');
        colInfo.className = "col-11 d-flex justify-items-center align-items-start";
        const p = document.createElement('p');
        const span = document.createElement('span');
        span.className = "me-2";
        span.textContent = mensaje.usuarioNom;

        // Icono de accion
        const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svg.setAttribute("id", `mensajeTrigger${datosIniciales["idMensaje"]}`);
        svg.setAttribute("data-mensaje-index", index);
        svg.setAttribute("width", "24");
        svg.setAttribute("height", "24");
        svg.setAttribute("fill", "currentColor");
        if (mensaje["idMensaje"] == datosIniciales["idMensaje"]) {
            svg.classList.add("action", "bi", "bi-exclamation-triangle-fill");
            svg.innerHTML = `<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>`;
        } else {
            svg.classList.add("action", "bi", "bi-person-check-fill");
            svg.innerHTML = `<path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>`;
        }
        svg.setAttribute("viewBox", "0 0 16 16");


        p.appendChild(span);
        p.appendChild(svg);
        colInfo.appendChild(p);

        // Mensaje
        const mensajeTextRow = document.createElement('div');
        mensajeTextRow.className = "row";
        const colText = document.createElement('div');
        colText.className = "col-12";
        colText.innerHTML = mensaje.texto;
        mensajeTextRow.appendChild(colText);

        mensajeRow.appendChild(colImg);
        mensajeRow.appendChild(colInfo);
        mensajeRow.appendChild(mensajeTextRow);
        mensajeContendor.appendChild(mensajeRow);

        // Agrega el evento de click al icono de accion
        svg.addEventListener('click', function () {
            datosReporte = mensaje;
            console.log(datosReporte);
            reportModal.show();
        });
    });
    //Funcion que quita el ticket
    quitarTicket.addEventListener('click', function () {
        fetch('../controladores/admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'quitarTicket',
                tipo: 'chatForo',
                id: datosIniciales.id
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.estado) {
                    alert('Ticket quitado correctamente');
                    window.location.href = '../vista/admin.php';
                } else {
                    alert('Error al quitar el ticket: ' + data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error quitando el ticket:', error);
            });
    });
    //Funcion que quita una partida y todos sus tickets
    quitarMensaje.addEventListener('click', function () {
        fetch('../controladores/admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'sentenciarTicketforoMensaje',
                idMensaje: datosReporte.idMensaje
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.estado) {
                    const mensajeRow = document.getElementById('mensaje' + datosReporte.idMensaje);
                    mensajeRow.remove();
                    alert('Mensaje Eliminado correctamente');
                } else {
                    alert('Error al sentenciar el ticket: ' + data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error sentenciando el ticket:', error);
            });
    });
    // Funcion que quita el usuario
    quitarUsuario.addEventListener('click', function () {
        fetch('../controladores/admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'sentenciarTicketUsuario',
                idUsuario: datosReporte.usuarioId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.estado) {
                    fetch('../controladores/admin.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            action: 'cojerIdMensajesEliminadosPrivados',
                            idChat: datosIniciales.idChat,
                            idUsuario: datosReporte.usuarioId
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            for (let i = 0; i < data.length; i++) {
                                const mensajeRow = document.getElementById('mensaje' + data[i]);
                                mensajeRow.remove();
                            }
                            alert('Usuario Eliminado correctamente');
                        })
                        .catch(error => {
                            console.error('Error quitando los mensajes del chat:', error);
                        })
                } else {
                    alert('Error al sentenciar el ticket: ' + data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error sentenciando el ticket:', error);
            });
    });
    console.log(datosIniciales);
});