<?php require_once("./header.php"); ?>
<main class="card mb-4 mt-4 col-md-6 offset-md-3 w-md-50">
    <div class="card-body mb-3 mt-3">
        <h2 class="card-title">INICIAR SESIÓN</h2>
        <div id="formularioIntroUser">
            <div class="mb-3">
                <label for="nom">NOMBRE:</label>
                <input type="text" class="form-control" name="nom" value=<?php if (isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"] ?>>
            </div>
            <div class="mb-3">
                <label for="contra">CONTRASEÑA:</label>
                <input type="password" class="form-control" name="contra">
            </div>
            <div class="mb-3">
                <input type="checkbox" name="rec" <?php if (isset($_COOKIE["usuario"])) echo "checked"; ?>>
                <label for="rec">Recordar Usuario</label>
            </div>
            <div class="mb-3">
                <button name="enviar" class="btn btn-primary col-12">INICIAR SESIÓN</button>
            </div>
            <a href="../vista/introUser.php"><button class="btn btn-success col-12" type="submit">REGISTRARSE</button></a>
        </div>
    </div>
</main>
<script src="../src/login.js"></script>
<?php require_once("./footer.php"); ?>
