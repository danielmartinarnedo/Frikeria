document.addEventListener('DOMContentLoaded', function () {
    // VARIALBLES
    const container = document.getElementById('partidas-container');
    //FUNCIONES

    //CODIGO GENERICO

    //CARGARS LAS PARTIDAS EN EL CONTENEDOR DESDE LA BASE DE DATOS
    // Se obtiene la ubicación del usuario y se envía una solicitud al servidor para buscar partidas cercanas
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                let lat = position.coords.latitude;
                let lng = position.coords.longitude;

                fetch('../controladores/normal.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'buscarPartida',
                        lat: lat,
                        lng: lng
                    })
                })
                    .then(response => response.json())
                    .then(datos => {

                        datos.forEach(partida => {
                            const row = document.createElement('div');
                            row.className = 'row justify-content-center mb-4';
                        
                            row.innerHTML =`
                            <div class="col-12 mt-3 pb-1 pt-1 border bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <img class="img-fluid h-100" src="${partida.portada}" alt="Portada de ${partida.titulo}" srcset="">
                    </div>
                    <div class="col-8">
                        <h3>${partida.titulo}</h3>
                        <h4>${partida.juego}</h4>
                        <p>Número de jugadores: ${partida.numJugadores}</p>
                        <p>Fecha: ${partida.fecha}</p>
                        <p>Ciudad: ${partida.ciudad}</p>
                        <p>${partida.descripcion}</p>
                        <button class="btn btn-primary col-12" href="./verPartida.php?titulo=${encodeURIComponent(partida.titulo)}&juego=${encodeURIComponent(partida.juego)}&jugadores=${partida.numJugadores}&fecha=${partida.fecha}&ciudad=${encodeURIComponent(partida.ciudad)}&descripcion=${encodeURIComponent(partida.descripcion)}&portada=${encodeURIComponent(partida.portada)}">ENVIAR</button>
                    </div>
                </div>
            </div>
        </div>
                            `;
                        
                            container.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            },
            function (error) {
                console.error('Error al obtener la ubicación:', error.message);
            }
        );
    } else {
        console.error('La geolocalización no es compatible con este navegador.');
    }
});