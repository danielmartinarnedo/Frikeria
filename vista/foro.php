<?php require_once("./header.php"); ?>
<main class="container-fluid">
    <h2 class="text-center"><?php echo $_GET["titulo"]; ?></h2>
    <section id="foro-container" class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8" id="mensajes-container">
            <div class="container">
                
            </div>
        </div>
    </section>
    <section id="input-foro" class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8">
            <div class="mb-3">
                <label for="escribirMensaje" class="form-label">Escribe tu mensaje</label>
                <textarea class="form-control" id="escribirMensaje" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" id="enviar">Enviar</button>
        </div>
    </section>
</main>
<script src="../src/foro.js"></script>
<?php require_once("./footer.php"); ?>