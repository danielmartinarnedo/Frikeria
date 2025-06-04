<?php require_once('./header.php'); ?>
<section class="container">
    <div class="row">
        <h1 class="text-center">CONTROL DE TICKES</h1>
        <div class="col-12 mb-3 mt-3">
            <select name="selectTipo" id="selectTipo" class="form-select">
                <option value="todo" default>TODO</option>
                <option value="anuncio">ANUNCIOS</option>
                <option value="chatForo">CHATS DE FOROS</option>
                <option value="chatPrivado">CHATS PRIVADO</option>
                <option value="usuario">USUARIOS</option>
            </select>
        </div>
    </div>
</section>
<section class="container">
    <div class="row" id="ticketsContainer">
    </div>
</section>
<script src="../src/admin.js"></script>
<?php require_once('./footer.php'); ?>