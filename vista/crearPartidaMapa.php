<body>
    <h1 class="text-center">¿Donde quieres jugar?</h1>
    <div id="map" style="height: 500px; width: 100%;"></div>
    <form method="POST" action="./normal.php?action=crearPartida" enctype="multipart/form-data">
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">
        <input type="hidden" name="city" id="city">

        <input type="hidden" name="nombre" id="nombre" value="<?php echo $_POST['nombre']; ?>">
        <input type="hidden" name="juego" id="juego" value="<?php echo $_POST['juego']; ?>">
        <input type="hidden" name="numeroJugadores" id="numeroJugadores" value="<?php echo $_POST['numeroJugadores']; ?>">
        <input type="hidden" name="fechaInicio" id="fechaInicio" value="<?php echo $_POST['fechaInicio']; ?>">
        <input type="hidden" name="descripcion" id="descripcion" value="<?php echo $_POST['descripcion']; ?>">
        <input type="hidden" name="fotoRuta" id="fotoRuta" value="<?php echo $_POST['fotoRuta']; ?>">

        <button class="btn btn-primary col-12" type="submit" name="crearPartida">CREAR PARTIDA</button>
    </form>
</body>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQRBU4caqOv1t1Fi3NuI9ZlG8Eb9oV9mY&libraries=places&callback=initMap"></script>
<script src="../src/crearPartidaMapa.js"></script>