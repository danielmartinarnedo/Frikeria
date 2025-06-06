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

            // Mostrar los detalles en la consola
            console.log('Latitud:', lat);
            console.log('Longitud:', lng);
            console.log('Ciudad/Pueblo/Villa:', city);
        } else {
            console.error('La geocodificación falló debido a:', status);
        }
    });
}
function initMap() {
    const datosPost = window.datosPost || {};
    const lat = parseFloat(datosPost.latInit) || 0;
    const lng = parseFloat(datosPost.lngInit) || 0;
    console.log("Latitud inicial:", lat, "Longitud inicial:", lng);
    const PartidaLocInicial = {
        lat: lat,
        lng: lng
    }
    // Opciones del mapa
    var options = {
        zoom: 17,
        center: {
            lat: lat,
            lng: lng
        }
    };

    // Crear el mapa
    var map = new google.maps.Map(document.getElementById('map'), options);

    // Agregar un marcador
    var marker = new google.maps.Marker({
        position: {
            lat: lat,
            lng: lng
        },
        map: map,
        title: 'No has seleccionado una ubicación',
    });

    // Centrar el mapa y el marcador en la ubicación inicial
    map.setCenter(PartidaLocInicial);
    marker.setPosition(PartidaLocInicial);
    setTimeout(() => {
        map.setZoom(17);
    }, 100);

    geolocalizar(PartidaLocInicial);

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