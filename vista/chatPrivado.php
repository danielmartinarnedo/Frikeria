<input type="hidden" id="idChatPrivado" value="<?php echo $idChat; ?>">
<main class="container-fluid">
    <main class="container-fluid">
        <section id="foro-container" class="row d-flex justify-content-center align-items-center">
            <div class="col-11 col-md-8">
                <div class="container">
                    <div id="mensajes-container" class="row d-flex justify-content-center align-items-center">
                        
                    </div>
                </div>
            </div>
        </section>
    </main>
    <section class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8">
            <div class="mb-3">
                <label for="escribirMensaje" class="form-label">Escribe tu mensaje</label>
                <textarea class="form-control" id="escribirMensaje" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" id="enviar">Enviar</button>
        </div>
    </section>
</main>
<script src="../src/chatPrivado.js"></script>