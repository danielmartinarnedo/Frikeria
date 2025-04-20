<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
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
        }
    </script>
</head>
<body onload="initMap()">
    <h1>Google Map Example</h1>
    <div id="map" style="height: 500px; width: 100%;"></div>
</body>