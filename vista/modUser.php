<main class="card mb-3 mt-3 col-md-6 offset-md-3 w-md-50">
  <img src="<?php echo $datos["foto"]; ?>" class="card-img-top" alt="Tu foto de usuario" id="imgTag">
  <div class="card-body">
    <h5 class="card-title">MODIFICAR USUARIO</h5>
    <div id="formularioModUser">
      <div class="mb-3">
        <label for="nom">Nombre:</label>
        <input type="text" name="nom" class="form-control" value="<?php echo $datos["nom"]; ?>" required>
      </div>
      <div class="mb-3">
        <label for="mail">E-mail:</label>
        <input type="email" name="mail" class="form-control" value="<?php echo $datos["mail"]; ?>" required>
      </div>
      <div class="mb-3">
        <label for="contra1">Contraseña:</label>
        <input type="password" name="contra" class="form-control" value="<?php echo $datos["contra"]; ?>" required>
      </div>
      <div class="mb-3">
        <label for="foto">Foto:</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
      </div>
      <button name="enviar" class="btn btn-primary col-12">MODIFICAR</button>
    </div>
  </div>
</main>
<script src="../src/modUser.js"></script>
<!-- action="../../controladores/normal.php?action=modUsuario" method="post" enctype="multipart/form-data"  -->