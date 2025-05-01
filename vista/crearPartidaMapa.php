<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQRBU4caqOv1t1Fi3NuI9ZlG8Eb9oV9mY&libraries=places"></script>
<script>
    function geolocalizar(localizacion) {
        // Usar la API de Geocodificación para obtener el nombre de la ciudad/pueblo/villa
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            location: localizacion
        }, function(results, status) {
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
        // Opciones del mapa
        var options = {
            zoom: 8,
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
                function(position) {
                    // Centrar el mapa en la ubicación del usuario
                    var userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    marker.setPosition(userLocation);

                    geolocalizar(userLocation)
                },
                function(error) {
                    console.error('Error al obtener la ubicación:', error.message);
                }
            );
        } else {
            console.error('La geolocalización no es compatible con este navegador.');
        }

        // Agregar un listener para los clics en el mapa
        google.maps.event.addListener(map, 'click', function(event) {
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
</script>

<body onload="initMap()">
    <h1 class="text-center">¿Donde quieres jugar?</h1>
    <div id="map" style="height: 500px; width: 100%;"></div>
    <form method="POST" action="./normal.php?action=crearPartida" enctype="multipart/form-data">
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">
        <input type="hidden" name="city" id="city">

        <button class="btn btn-primary col-12" type="submit" name="crearPartida">CREAR PARTIDA</button>
    </form>
</body>