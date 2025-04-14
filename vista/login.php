<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lumen/bootstrap.min.css">
</head>
<body>
    <main>
        <form action="../index.php?action=inicio" method="post">
            <label for="nom">Nombre de usuario</label>
            <input type="text" name="nom" value=<?php if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"] ?>>
            <br>
            <label for="contra">Contraseña</label>
            <input type="password" name="contra">
            <br>
            <input type="checkbox" name="rec" <?php if(isset($_COOKIE["usuario"])) echo "checked"; ?>>
            <label for="rec">Recordar Usuario</label>
            <br>
            <input type="submit" value="Enviar" name="fIni">
        </form>
    </main>
</body>
</html>