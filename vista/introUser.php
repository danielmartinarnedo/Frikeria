<?php require_once("./header.php"); ?>
<main class="card mb-3 mt-3 col-md-6 offset-md-3 w-md-50">
  <div class="card-body">
    <h2 class="card-title">INTRODUCIR USUARIO</h2>
    <div id="formularioIntroUser">
      <div class="mb-3">
        <label for="nom">NOMBRE:</label>
        <input type="text" class="form-control"  name="nom" required>
      </div>
      <div class="mb-3">
        <label for="mail">E-MAIL</label>
        <input type="email" class="form-control"  name="mail" required>
      </div>
      <div class="mb-3">
        <label for="contra1">CONTRASEÑA</label>
        <input type="password" class="form-control"  name="contra" required>
      </div>
      <div class="mb-3">
        <label for="contra2">REPETIR CONTRASEÑA</label>
        <input type="password" class="form-control" name="contra2" required>
      </div>
      <button name="enviar" class="btn btn-primary col-12">REGISTRARSE</button>
    </div>
  </div>
</main>
<script src="../src/introUser.js"></script>
<?php require_once("./footer.php"); ?>
<!-- action="../../controladores/normal.php?action=insertarUsuario" method="post" -->