<?php require_once("./header.php"); ?>
<main class="card mb-3 mt-3 col-md-6 offset-md-3 w-md-50">
  <img src="" class="card-img-top d-none" alt="Foto de la Partida" id="imgTag">
  <div class="card-body">
    <h5 class="card-title">CREAR PARTIDA</h5>
    <div id="crearPartidaForm">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" minlength="5" required>
        </div>
        <div class="mb-3">
            <label for="juego" class="form-label">Juego</label>
            <input type="text" class="form-control" name="juego" minlength="3" required>
        </div>
        <div class="mb-3">
            <label for="numeroJugadores" class="form-label">Número de Jugadores</label>
            <input type="number" class="form-control" name="numeroJugadores" min="0" required>
        </div>
        <div class="mb-3">
            <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" name="fechaInicio" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
        </div>
        <div class="mb-3">
            <label for="portada" class="form-label">Portada</label>
            <input type="file" class="form-control" name="portada" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" rows="3" required></textarea>
        </div>
        <button name="enviar" class="btn btn-primary col-12">CREAR</button>
    </div>
</main>
<script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="summernote-bs5.js"></script>
<script src="../src/modPartida.js"></script>
<?php require_once("./footer.php"); ?>

<!--  action="../controladores/normal.php?action=descargarFoto" method="POST" enctype="multipart/form-data"  -->