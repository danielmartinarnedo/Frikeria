<?php require_once("../vista/header.php"); ?>

<main class="container">
    <section id="partida-container" class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <img src="<?php echo $_GET["portada"]; ?>" class="card-img-top" alt="Portada de la partida">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $_GET["titulo"]; ?></h5>
                    <h4 class="card-subtitle mb-2 text-muted"><?php echo $_GET["juego"]; ?></h6>
                    <p class="card-text"><?php echo $_GET["jugadores"]; ?></p>
                    <p class="card-text"><?php echo $_GET["fecha"]; ?></p>
                    <p class="card-text"><?php echo $_GET["descripcion"]; ?></p>
                    <a class="btn btn-primary col-12" href="../normal.php?action=irForo?foro=<?php echo $_GET["foro"]; ?>">IR AL FORO</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once("../vista/footer.php"); ?>