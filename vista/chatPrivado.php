<input type="hidden" id="idChatPrivado" value="<?php echo $idChat; ?>">
<main class="container">
    <div class="row" id="areaMensajes">
        <div class="col-12">
            <!-- 75% height content -->
        </div>
    </div>
    <div class="row" id="areaInput">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-11">
                        <textarea name="escribirMensaje" id="escribirMensaje" class="w-100 no-resize"></textarea>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-primary" id="btnEnviarMensaje" class="w-100">></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="../src/chatPrivado.js"></script>