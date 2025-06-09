function geolocalizar(localizacion) {
    // Usar la API de Geocodificación para obtener el nombre de la ciudad/pueblo/villa
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        location: localizacion
    }, function (results, status) {
        if (status === 'OK' && results[0]) {
            // Extraer el nombre de la ciudad/pueblo/villa
            var addressComponents = results[0].address_components;
            var city = addressComponents.find(component =>
                component.types.includes('locality') ||
                component.types.includes('administrative_area_level_2')
            )?.long_name || 'Desconocido';

            var lat = localizacion["lat"];
            var lng = localizacion["lng"];

            // Actualizar el marcador con la información de la ubicación
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            document.getElementById('city').value = city;

        } else {
            console.error('La geocodificación falló debido a:', status);
        }
    });
}
function initMap() {
    // Opciones del mapa
    var options = {
        zoom: 17,
        center: {
            lat: 0,
            lng: 0
        }
    };

    // Crear el mapa
    var map = new google.maps.Map(document.getElementById('map'), options);

    // Agregar un marcador
    var marker = new google.maps.Marker({
        position: {
            lat: 0,
            lng: 0
        },
        map: map,
        title: 'No has seleccionado una ubicación',
    });

    // Solicitar permiso para obtener la ubicación del usuario
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                // Centrar el mapa en la ubicación del usuario
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(userLocation);
                marker.setPosition(userLocation);
                setTimeout(() => {
                    map.setZoom(17);
                }, 100);

                geolocalizar(userLocation);
            },
            function (error) {
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        console.error('La geolocalización no es compatible con este navegador.');
    }

    // Agregar un listener para los clics en el mapa
    google.maps.event.addListener(map, 'click', function (event) {
        // Colocar el marcador en la ubicación clickeada
        marker.setPosition(event.latLng);
        const clickedLocation = {
            lat: event.latLng.lat(),
            lng: event.latLng.lng()
        };

        // Pasar al método geolocalizar
        geolocalizar(clickedLocation);
    });
}
document.addEventListener('DOMContentLoaded', () => {



});