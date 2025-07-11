<?php require_once("./header.php"); ?>
<main class="container-fluid">
    <h2 class="text-center"><?php echo $_GET["titulo"]; ?></h2>
    <section class="container-fluid">
        <div id="foro-container" class="row d-flex justify-content-center align-items-center">
            <div class="col-11 col-md-8">
                <div class="container">
                    <div id="mensajes-container" class="row d-flex justify-content-center align-items-center">

                    </div>
                </div>
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
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">REPORTE DE ANUNCIO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="tipoReporte" class="form-label">TIPO DEL REPORTE:</label>
                    <select id="reporteOpcion" class="form-select">
                        <option value="usuario">USUARIO</option>
                        <option value="mensaje" selected>MENSAJE</option>
                    </select>
                    <label for="reporteDescripcion" class="form-label">DESCRIPCIÓN DEL REPORTE:</label>
                    <textarea id="reporteDescripcion" class="form-control" rows="10" style="resize: none;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id="reportarBoton" class="col-12 btn bg-danger text-white">REPORTAR</button>
                    <button type="button" id="bloquearBoton" class="col-12 btn bg-danger text-white">BLOQUEAR</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="../src/foro.js"></script>
<?php require_once("./footer.php"); ?>