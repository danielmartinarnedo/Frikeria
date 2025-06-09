document.addEventListener('DOMContentLoaded', function () {
    const buscarPartida = document.getElementById('buscarPartida');

    buscarPartida.addEventListener('click', function () {
        fetch('../controladores/normal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'irLandingOrBuscarPartida'
            })
        })
        .then(response => response.json())
        .then(data => {
            window.location.href = data;
        })
        .catch(error => {
            console.error('Error sentenciando el ticket:', error);
        });
    });
});