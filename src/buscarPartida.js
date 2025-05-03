document.addEventListener('DOMContentLoaded', function () {    //VARIABLES
    var permisos = false;
    //FUNCIONES
    //CODIGO GENERAL
    // Solicitar permiso para obtener la ubicación del usuario
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                // Centrar el mapa en la ubicación del usuario
                let lat= position.coords.latitude
                let lng= position.coords.longitude
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
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => console.error('Error:', error));

                permisos = true;

                console.log('Ubicación del usuario:', lat, lng);
            },
            function (error) {
                console.error('Error al obtener la ubicación:', error.message);
            }
        );
    } else {
        console.error('La geolocalización no es compatible con este navegador.');
        
    }
});