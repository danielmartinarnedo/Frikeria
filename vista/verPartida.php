<?php session_start(); require_once("../vista/header.php"); ?>
<?php foreach ($_GET as $key => $value): ?>
    <input type="hidden" name="<?php echo htmlspecialchars($key, ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
<?php endforeach; ?>
<main class="container">
    <section id="partida-container" class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <img src="<?php echo $_GET["portada"]; ?>" class="card-img-top" alt="Portada de la partida">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $_GET["titulo"]; ?></h5>
                        <h4 class="card-subtitle mb-2 text-muted"><?php echo $_GET["juego"]; ?></h6>
                            <p class="card-text">NÚMERO DE JUGADORES: <?php echo $_GET["jugadores"]; ?></p>
                            <p class="card-text">CREADOR: <?php
                                                            echo htmlspecialchars($_GET["creador"] ?? $_SESSION["user"], ENT_QUOTES); ?></p>
                            <p class="card-text">FECHA: <?php echo $_GET["fecha"]; ?></p>
                            <p class="card-text">MUNCIPIO: <?php echo $_GET["ciudad"]; ?></p>
                            <div class="card-text"><?php echo $_GET["descripcion"]; ?></div>
                            <a class="btn btn-primary col-12" href="./foro.php?foro=<?php echo $_GET["foro"]; ?>&titulo=<?php echo $_GET["titulo"]; ?>">IR AL FORO</a>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">REPORTE DE ANUNCIO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="reporteDescripcion" class="form-label">DESCRIPCIÓN DEL REPORTE:</label>
                    <textarea id="reporteDescripcion" class="form-control" rows="10" style="resize: none;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id="reportarBoton" class="col-12 btn bg-danger text-white">REPORTAR</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="../src/verPartida.js"></script>
<?php require_once("../vista/footer.php"); ?>