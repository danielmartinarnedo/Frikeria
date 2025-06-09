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
                            row.className = 'card col-12 col-md-5 mt-3 mb-3 me-1 ms-1 pb-1 pt-1 border bg-light';

                            row.innerHTML = `
                                    <img class="img-fluid card-img-top anuncioImagen" src="${partida.portada}" alt="Portada de ${partida.titulo}" srcset="">
                                    <div class="card-body">
                                        <h3 class="card-title">${partida.titulo}</h3>
                                        <h4 class="card-subtitle mb-2 text-body-secondary">${partida.juego}</h4>
                                        <p class="card-text">CREADOR DEL ANUNCIO: ${partida.nombreCreador}</p>
                                        <p class="card-text">NÚMERO DE JUGADORES: ${partida.numJugadores}</p>
                                        <p class="card-text">FECHA: ${partida.fecha}</p>
                                        <p class="card-text">MUNICIPIO: ${partida.ciudad}</p>
                                        <p class="card-text text-truncate">${partida.descripcion}</p>                
                                    </div>
                                    <div class="card-footer">
                                        <a class="btn btn-primary col-12" 
                                        href="./verPartida.php?titulo=${encodeURIComponent(partida.titulo)}&juego=${encodeURIComponent(partida.juego)}&jugadores=${partida.numJugadores}&fecha=${partida.fecha}&ciudad=${encodeURIComponent(partida.ciudad)}&descripcion=${encodeURIComponent(partida.descripcion)}&portada=${encodeURIComponent(partida.portada)}&foro=${encodeURIComponent(partida.id)}&creador=${encodeURIComponent(partida.nombreCreador)}&lat=${partida.latitud}&lng=${partida.longitud}">
                                        VER PARTIDA
                                        </a>                                        
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