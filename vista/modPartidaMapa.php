<main>
    <h1 class="text-center">¿Donde quieres jugar?</h1>
    <div id="map" style="height: 500px; width: 100%;"></div>
    <form method="POST" action="./normal.php?action=modPartida" enctype="multipart/form-data">
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">
        <input type="hidden" name="city" id="city">

        <?php
        foreach ($_POST as $key => $value) {
            if ($key != 'latInit' || $key != 'lngInit') {
                echo "<input type=\"hidden\" name=\"$key\" id=\"$key\" value=\"htmlspecialchars($value, ENT_QUOTES, 'UTF-8')\">\n";
            }
        }
        ?>
        <button class="btn btn-primary col-12" type="submit" name="crearPartida">MODIFICAR PARTIDA</button>
    </form>
</main>
<script>window.datosPost = <?php echo json_encode($_POST); ?>;</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQRBU4caqOv1t1Fi3NuI9ZlG8Eb9oV9mY&libraries=places&callback=initMap"></script>
<script src="../src/modPartidaMapa.js"></script>