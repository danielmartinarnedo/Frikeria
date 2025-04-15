<?php require_once("./header.php"); ?>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card">
        <div class="card-body">
            <main>
                <form action="../index.php?action=inicio" method="post">
                    <label for="nom">Nombre o Email:</label>
                    <input type="text" name="nom" value=<?php if (isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"] ?>>
                    <br>
                    <label for="contra">Contraseña:</label>
                    <input type="password" name="contra">
                    <br>
                    <input type="checkbox" name="rec" <?php if (isset($_COOKIE["usuario"])) echo "checked"; ?>>
                    <label for="rec">Recordar Usuario</label>
                    <br>
                    <input type="submit" value="Enviar" name="fIni" class="btn btn-primary">
                </form>
                <a href="./normal/introUser.php"><button class="btn btn-primary" type="submit">Registrate</button></a>
            </main>
        </div>
    </div>
</div>
<?php require_once("./footer.php"); ?>