<main class="card mb-3 mt-3 col-md-6 offset-md-3 w-md-50">
  <img src="<?php echo $datos["foto"]; ?>" class="card-img-top" alt="Tu foto de usuario" id="imgTag">
  <div class="card-body">
    <h5 class="card-title">MODIFICAR USUARIO</h5>
    <div id="formularioModUser">
      <label for="nom">Nombre:</label>
      <input type="text" name="nom" value="<?php echo $datos["nom"]; ?>" required>
      <br>
      <label for="mail">E-mail:</label>
      <input type="email" name="mail" value="<?php echo $datos["mail"]; ?>" required>
      <br>
      <label for="contra1">Contraseña:</label>
      <input type="password" name="contra" value="<?php echo $datos["contra"]; ?>" required>
      <br>
      <label for="foto">Foto:</label>
      <input type="file" name="foto" accept="image/*">
      <br>
      <input type="submit" value="Modificar" name="enviar">
    </div>
  </div>
</main>
<script src="../src/modUser.js"></script>
<!-- action="../../controladores/normal.php?action=modUsuario" method="post" enctype="multipart/form-data"  -->