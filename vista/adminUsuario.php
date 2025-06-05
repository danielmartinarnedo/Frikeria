<main>
    <div class="card mb-3 mt-3 col-md-6 offset-md-3 w-md-50">
        <img src="" class="card-img-top" alt="Imagen de usuario">
        <div class="card-header">
            <h2 class="card-title">USUARIOS</h2>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
        </div>
        <div class="card-footer d-flex">
            <button class="btn btn-success col-6 text-white">QUITAR TICKET</button>
            <button class="btn btn-danger col-6 text-white">SENTENCIAR</button>
        </div>
    </div>
</main>
<?php
foreach ($_POST as $key => $value) {
    echo "<input type='hidden' name='{$key}' value='{$value}'>";
}
?>
<script src="../src/adminUsuario.js"></script>