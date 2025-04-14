<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lumen/bootstrap.min.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <p class="navbar-brand">PRACTICA</p>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="../../controladores/normal.php?action=irListaAmigo">AMIGOS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../controladores/normal.php?action=irListaJuego">JUEGOS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../controladores/normal.php?action=irListaPrestamo">PRESTAMOS</a>
        </li>
        <?php
            require_once('../../classes/usuario.php');
            require_once('../../modelo.php');
            $usus = new usuario("../../../../../");
            if($usus->compAdmin(get_session('user'))){
                echo '<a class="nav-link" href="../admin.php?action=irLista">ADMIN</a>';
            }
        ?>
        <div class="nav-item">
            <a class="nav-link" href="../../controladores/normal.php?action=cerrarSes">Cerrar Session</a>
        </div>  
    </div>
  </div>
</nav>
<body>
    <h2>INTRODUCIR USUARIO</h2>
    <form action="../../controladores/admin.php?action=insertar" method="post">
        <label for="nom">Nombre</label>
        <input type="text" name="nom" required>
        <br>
        <label for="contra">Contraseña</label>
        <input type="password" name="contra" required>
        <br>
        <input type="submit" value="Introducir" name="enviar">
    </form>
</body>
</html>