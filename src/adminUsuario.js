document.addEventListener('DOMContentLoaded', function () {
    // VARIABLES
    const foto = document.querySelector('.card-img-top');
    const titulo = document.querySelector('.card-title');
    const descripcion = document.querySelector('.card-text');
    const quitarTicket = document.querySelector('.btn-success');
    const sentenciarTicket = document.querySelector('.btn-danger');
    const getPostDatos = document.querySelectorAll('input[type="hidden"]')
    const datos = {};
    getPostDatos.forEach(input => {
        datos[input.name] = input.value;
        input.remove();
    });
    // FUNCIONES


    // CODIGO GENERICO
    fetch('../controladores/admin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'getDatosUsuario',
            id: datos.idUsuario
        })
    })
        .then(response => response.json())
        .then(data => {
            foto.src = data.foto;
            titulo.textContent = data.nom;
        })
        .catch(error => {
            console.error('Error al cargar los datos del usuario:', error);
        });
    descripcion.textContent = datos.descripcion;
    quitarTicket.addEventListener('click', function () {
        fetch('../controladores/admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'quitarTicket',
                tipo: 'usuario',
                id: datos.id
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
    sentenciarTicket.addEventListener('click', function () {
        fetch('../controladores/admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'sentenciarTicketUsuario',
                idUsuario: datos.idUsuario
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.estado) {
                    alert('Usuario Eliminado correctamente');
                    window.location.href = '../vista/admin.php';
                } else {
                    alert('Error al sentenciar el ticket: ' + data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error sentenciando el ticket:', error);
            });
    });
});

