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
                console.log(datos);
                padreLista.innerHTML = '';
                datos.forEach(chat => {
                    padreLista.innerHTML += `
                        <div class="container border-bottom mb-3" data-id="${chat.idChat}">
                            <div class="row align-items-center">
                                <div class="col-1"><img class="logoUser" src="${chat.foto}" alt="Logo de ${chat.nombre}"></div>
                                <div class="col-11">${chat.nombre}</div>
                                <div class="col-12 text-truncate">Ultimo Mensaje: ${chat.ultimoMensaje}</div>
                            </div>
                        </div>
                    `;
                })
            });
    }

    //CODIGO GENERICO
    cargarChatPrivado()
});