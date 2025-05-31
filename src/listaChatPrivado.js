document.addEventListener('DOMContentLoaded', function () {
    // VARIALBLES
    const padreLista = document.getElementById('listaChat');

    //FUNCIONES
    function cargarChatPrivado() {
        fetch('../controladores/normal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'buscarChatsPrivados'
            })
        })
            .then(response => response.json()).then(datos => {
                padreLista.innerHTML = '';
                datos.forEach(chat => {
                    padreLista.innerHTML += `
                        <div class="container border-bottom mb-3" data-id="${chat.nombre}">
                            <div class="row align-items-center">
                                <div class="col-1"><img class="logoUser" src="${chat.foto}" alt="Logo de ${chat.nombre}"></div>
                                <div class="col-11 fw-bold">${chat.nombre}</div>
                                <div class="col-12 text-truncate"><span class="fw-bold">${chat.nombreUsuario}:</span> ${chat.ultimoMensaje}</div>
                            </div>
                        </div>
                    `;
                    const chatPrivado = document.querySelector(`[data-id="${chat.nombre}"]`);
                    chatPrivado.addEventListener('click', function () {
                        window.location.href = `../controladores/normal.php?action=irChatPrivado&usuarioNom=${chat.nombre}`;
                    });
                })
            });
    }

    //CODIGO GENERICO
    cargarChatPrivado()
});