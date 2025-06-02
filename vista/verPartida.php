<?php require_once("../vista/header.php"); ?>
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
                    <p class="card-text">CREADOR: <?php echo $_GET["creador"]; ?></p>
                    <p class="card-text">FECHA: <?php echo $_GET["fecha"]; ?></p>
                    <p class="card-text">MUNCIPIO: <?php echo $_GET["ciudad"]; ?></p>
                    <p class="card-text">DESCRIPCIÓN:<?php echo $_GET["descripcion"]; ?></p>
                    <a class="btn btn-primary col-12" href="./foro.php?foro=<?php echo $_GET["foro"]; ?>&titulo=<?php echo $_GET["titulo"]; ?>">IR AL FORO</a>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="../src/verPartida.js"></script>
<?php require_once("../vista/footer.php"); ?>