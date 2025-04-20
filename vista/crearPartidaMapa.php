<?php require_once("./header.php"); ?>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQRBU4caqOv1t1Fi3NuI9ZlG8Eb9oV9mY"></script>
<script>
    function initMap() {
        // Map options
        var options = {
            zoom: 8,
            center: { lat: 40.7128, lng: -74.0060 } // Coordinates for New York City
        };

        // Create the map
        var map = new google.maps.Map(document.getElementById('map'), options);

        // Add a marker
        var marker = new google.maps.Marker({
            position: { lat: 40.7128, lng: -74.0060 },
            map: map,
            title: 'New York City'
        });

        // Add a click listener to the map
        google.maps.event.addListener(map, 'click', function(event) {
            // Place the marker at the clicked location
            marker.setPosition(event.latLng); // Corrected line

            // Get latitude and longitude
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();

            // Use Geocoding API to get the city/town/village name
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: event.latLng }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    // Extract the city/town/village name
                    var addressComponents = results[0].address_components;
                    var city = addressComponents.find(component =>
                        component.types.includes('locality') ||
                        component.types.includes('administrative_area_level_2')
                    )?.long_name || 'Unknown';

                    // Log the details to the console
                    console.log('Latitude:', lat);
                    console.log('Longitude:', lng);
                    console.log('City/Town/Village:', city);
                } else {
                    console.error('Geocoder failed due to:', status);
                }
            });
        });
    }
</script>
</head>
<body onload="initMap()">
    <h1>Google Map Example</h1>
    <div id="map" style="height: 500px; width: 100%;"></div>
</body>
<?php require_once("./footer.php"); ?>
