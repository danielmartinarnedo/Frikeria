<?php require_once("../header.php"); ?>
<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="card" style="width: 30rem;">
    <div class="card-body">
      <h2 class="text-center">INTRODUCIR USUARIO</h2>
      <form action="../../controladores/normal.php?action=insertarUsuario" method="post">
        <label for="nom">Nombre</label>
        <input type="text" name="nom" required>
        <br>
        <label for="mail">E-mail</label>
        <input type="email" name="mail" required>
        <br>
        <label for="contra1">Contraseña</label>
        <input type="password" name="contra" required>
        <br>
        <label for="contra2">Repetir Contraseña</label>
        <input type="password" name="contra2" required>
        <br>
        <input type="submit" value="Introducir" name="enviar">
      </form>
    </div>
  </div>
</div>
<?php require_once("../header.php"); ?>