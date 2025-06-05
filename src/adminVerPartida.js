document.addEventListener('DOMContentLoaded', () => {
    //VARIABLES
    const valoresInput = document.querySelectorAll('input[type="hidden"]');
    const quitarTicket = document.querySelector('.btn-success');
    const quitarPartida = document.getElementById('quitarPartida');
    const quitarUsuario = document.getElementById('quitarUsuario');
    const partida = {};
    valoresInput.forEach(input => {
        partida[input.name] = input.value;
        input.remove();
    })
    console.log(partida);
    //FUNCIONES
    //Funcion que quita una partida y todos sus tickets
    function removerPartida() {

    }

    //CODIGO GENERICO
    quitarTicket.addEventListener('click', function () {
        fetch('../controladores/admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'quitarTicket',
                tipo: 'anuncio',
                id: partida.id
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
    quitarPartida.addEventListener('click', function () {
        fetch('../controladores/admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'sentenciarTicketPartida',
                idPartida: partida.idPartida
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
    // Funcion que quita el usuario
    quitarUsuario.addEventListener('click', function () {
        fetch('../controladores/admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'sentenciarTicketUsuario',
                idUsuario: partida.anuncio_idCreador
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