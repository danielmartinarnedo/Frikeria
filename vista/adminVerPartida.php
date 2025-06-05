<?php foreach ($_POST as $key => $value): ?>
    <input type="hidden" name="<?php echo htmlspecialchars($key, ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
<?php endforeach; ?>
<?php foreach ($anuncio as $key => $value): ?>
    <input type="hidden" name="anuncio_<?php echo htmlspecialchars($key, ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
<?php endforeach; ?>
<main class="container">
    <section id="partida-container" class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8">
            <div class="card mt-3 mb-3  ">
                <div class="card-header">
                    <p class="card-subtitle">DESCRIPCION DEL TICKET:</p>
                    <p class="card-text"><?php echo $_POST["descripcion"]; ?></p>
                </div>
                <img src="<?php echo $anuncio["portada"]; ?>" class="card-img-top p-1" alt="Portada de la partida">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $anuncio["titulo"]; ?></h5>
                        <h4 class="card-subtitle mb-2 text-muted"><?php $anuncio["juego"]; ?></h6>
                            <p class="card-text">NÚMERO DE JUGADORES: <?php $anuncio["numJugadores"]; ?></p>
                            <p class="card-text">CREADOR: <?php session_start();
                                                            echo htmlspecialchars($anuncio["nombreCreador"]); ?></p>
                            <p class="card-text">FECHA: <?php echo $anuncio["fecha"]; ?></p>
                            <p class="card-text">MUNCIPIO: <?php echo $anuncio["ciudad"]; ?></p>
                            <div class="card-text"><?php echo $anuncio["descripcion"]; ?></div>
                </div>
                <div class="card-footer d-flexr">
                    <button class="btn col-12 btn-danger mb-3 text-white" id="quitarPartida">SENTENCIAR PARTIDA</button>
                    <button class="btn col-12 btn-danger mb-3 text-white" id="quitarUsuario">SENTENCIAR USUARIO Y PARTIDA</button>
                    <button class="btn col-12 btn-success text-white">QUITAR TICKET</button>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="../src/adminVerPartida.js"></script>