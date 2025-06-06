<?php
foreach ($_POST as $key => $value) {
    echo "<input type='hidden' name='{$key}' value='{$value}'>";
}
foreach ($mensajes as $key => $value) {
    if (is_array($value)) {
        $value = htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8');
    }
    echo "<input type='hidden' name='chat_{$key}' value='{$value}'>";
}
?>
<main class="container-fluid">
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
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">OPCIONES DE TICKET</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="btn col-12 btn-danger mb-3 text-white" id="quitarMensaje">SENTENCIAR MENSAJE</button>
                    <button class="btn col-12 btn-danger mb-3 text-white" id="quitarUsuario">SENTENCIAR USUARIO</button>
                    <button class="btn col-12 btn-success text-white">QUITAR TICKET</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="../src/adminChatPrivado.js"></script>