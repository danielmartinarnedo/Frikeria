<?php require_once("./header.php"); ?>

<div class="container mt-5">
    <h1 class="mb-4">Crear Partida</h1>
    <form id="crearPartidaForm" action="../controladores/normal.php?action=irMapa" method="POST" enctype="multipart/form-data" class="mb-5">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" minlength="5" required>
        </div>
        <div class="mb-3">
            <label for="juego" class="form-label">Juego</label>
            <input type="text" class="form-control" id="juego" name="juego" minlength="3" required>
        </div>
        <div class="mb-3">
            <label for="numeroJugadores" class="form-label">Número de Jugadores</label>
            <input type="number" class="form-control" id="numeroJugadores" name="numeroJugadores" min="0" required>
        </div>
        <div class="mb-3">
            <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
        </div>
        <div class="mb-3">
            <label for="portada" class="form-label">Portada</label>
            <input type="file" class="form-control" id="portada" name="portada" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">CREAR</button>
    </form>
</div>

<script>
    document.getElementById('crearPartidaForm').addEventListener('submit', function(event) {
        const portadaInput = document.getElementById('portada');
        const file = portadaInput.files[0];

        if (file) {
            // Check if the MIME type starts with "image/"
            if (!file.type.startsWith('image/')) {
                event.preventDefault(); // Prevent form submission
                alert('El archivo debe ser una imagen válida.'); // Show alert
            }
        } else {
            event.preventDefault(); // Prevent form submission if no file is selected
            alert('Por favor, selecciona un archivo de imagen.'); // Show alert
        }
    });
</script>

<?php require_once("./footer.php"); ?>
