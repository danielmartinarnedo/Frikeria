<?php require_once("./header.php"); ?>
<main class="card mb-3 mt-3 col-md-6 offset-md-3 w-md-50">
    <img src="<?php echo $_GET['portada']; ?>" class="card-img-top" alt="Foto de la Partida" id="imgTag">
    <div class="card-body">
        <h5 class="card-title">MODIFICAR PARTIDA</h5>
        <div id="crearPartidaForm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" minlength="5" value="<?php echo $_GET['titulo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="juego" class="form-label">Juego</label>
                <input type="text" class="form-control" name="juego" minlength="3" value="<?php echo $_GET['juego']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="numeroJugadores" class="form-label">Número de Jugadores</label>
                <input type="number" class="form-control" name="numeroJugadores" min="0" value="<?php echo $_GET['jugadores']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" name="fechaInicio" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" value="<?php echo $_GET['fecha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="portada" class="form-label">Portada</label>
                <input type="file" class="form-control" name="portada" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
            </div>
            <button name="enviar" class="btn btn-primary col-12">MODIFICAR</button>
        </div>
</main>
<input type="hidden" name="descripcionGET" value="<?php echo htmlspecialchars($_GET['descripcion'], ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="lat" value="<?php echo $_GET['lat']; ?>">
<input type="hidden" name="lng" value="<?php echo $_GET['lng']; ?>">
<input type="hidden" name="idPartida" value="<?php echo $_GET['foro']; ?>">
<script src="../src/modPartida.js"></script>
<?php require_once("./footer.php"); ?>