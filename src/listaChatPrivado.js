document.addEventListener('DOMContentLoaded', function () {
    // VARIALBLES
    const padreLista = document.getElementById('listaChat');

    //FUNCIONES

    //CODIGO GENERICO
    function cargarChatPrivado() {
        fetch('../controladores/normal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'cargarChatPrivados'
            })
        })
            .then(response => response.json()).then(datos => {
                console.log(datos);
                datos.forEach(chat => {
                    padreLista.innerHTML += `
                <div class="card col-12 col-md-3" data-chat="${chat.id}">
                        <img class="logoUser" src="${mensaje.usuarioImg}" alt="logo de ${mensaje.usuarioNom}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                `;
                })
            });
    }
});