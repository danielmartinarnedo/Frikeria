document.addEventListener("DOMContentLoaded", function () {
    // VARIABLES
    const imgTag = document.getElementById('imgTag');
    const inputNombre = document.getElementsByName('nombre')[0];
    const inputJuego = document.getElementsByName('juego')[0];
    const inputNumeroJugadores = document.getElementsByName('numeroJugadores')[0];
    const inputFechaInicio = document.getElementsByName('fechaInicio')[0];
    const inputDescripcion = document.getElementsByName('descripcion')[0];
    const inputFoto = document.getElementsByName('portada')[0];
    const submitForm = document.getElementsByName('enviar')[0];

    // Funcion que valida el formulario
    function validacionFormulario() {
        let arrayValidado = {
            "estado": true,
            "msj": ""
        };

        if (inputNombre.value.trim().length < 3) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "El nombre de la partida debe tener minimo 3 caracteres.\n";
        }
        if (inputJuego.value.trim().length < 3) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "El nombre del juego debe tener minimo 3 caracteres.\n";
        }
        if (inputNumeroJugadores.value < 1) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "El numero de jugadores debe ser mayor a 0.\n";
        }
        if (inputDescripcion.value.trim().length < 50) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "La descripcion de la partida debe tener minimo 50 caracteres.\n";
        }

        // Validar que la fecha sea al menos mañana
        const fechaSeleccionada = new Date(inputFechaInicio.value);
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        const manana = new Date(hoy);
        manana.setDate(hoy.getDate() + 1);

        if (isNaN(fechaSeleccionada.getTime()) || fechaSeleccionada < manana) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "La fecha de inicio debe ser al menos mañana o una fecha posterior.\n";
        }

        // Valida si el archivo seleccionado es una imagen
        const fotoFile = inputFoto.files[0];
        if (fotoFile && !fotoFile.type.startsWith('image/')) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "No has seleccionado un archivo de imagen válido.\n";
        }

        return arrayValidado;
    }

    function crearPartida() {
        const validacion = validacionFormulario();
        if (!validacion.estado) {
            alert(validacion.msj);
        } else {
            const formularioDatos = new FormData();
            formularioDatos.append('nombre', inputNombre.value.trim());
            formularioDatos.append('juego', inputJuego.value.trim());
            formularioDatos.append('numeroJugadores', inputNumeroJugadores.value);
            formularioDatos.append('fechaInicio', inputFechaInicio.value);
            formularioDatos.append('descripcion', $(inputDescripcion).summernote('code').trim());
            if (inputFoto.files[0]) {
                formularioDatos.append('portada', inputFoto.files[0]);
            }
            console.log("Datos del formulario:", {
                nom: inputNombre.value.trim(),
                juego: inputJuego.value.trim(),
                numJugadores: inputNumeroJugadores.value,
                fechaInicio: inputFechaInicio.value,
                descripcion: inputDescripcion.value.trim(),
                foto: inputFoto.files[0] ? inputFoto.files[0].name : 'No file selected'
            });

            fetch('../controladores/normal.php?action=modPartidaForm', {
                method: 'POST',
                body: formularioDatos
            })
                .then(response => response.json())
                .then(data => {
                    if (data.estado) {
                        formularioDatos.append('fotoRuta', data.fotoRuta ?? imgTag.src);
                        const formularioMapa = document.createElement('form');
                        formularioMapa.method = 'POST';
                        formularioMapa.action = '../controladores/normal.php?action=irMapa';

                        for (const [key, value] of formularioDatos.entries()) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = value;
                            formularioMapa.appendChild(input);
                        }
                        document.body.appendChild(formularioMapa);
                        formularioMapa.submit();
                    } else {
                        alert(data.msj);
                    }
                })
                .catch(error => {
                    console.error('Error al crear la partida:', error);
                    alert("Ocurrió un error al crear la partida.");
                });
        }
    }

    inputFoto.addEventListener('change', (e) => {
        const file = e.target.files[0];

        if (file) {
            //Comprueba si el archivo es una imagen
            if (!file.type.startsWith('image/')) {
                alert('El archivo debe ser una imagen válida.');
                inputFoto.value = '';
                imgTag.src = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (event) => {
                imgTag.src = event.target.result;
                imgTag.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    submitForm.addEventListener('click', (e) => {
        crearPartida();
    });
    // Inicializa el Summernote para el campo de descripción
    $(inputDescripcion).summernote({
        height: 250,
        lang: 'es-ES',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'help']]
        ], callbacks: {
            onInit: function () {
                inputDescripcionValue = document.getElementsByName('descripcionGET')[0];
                $(inputDescripcion).summernote('code', inputDescripcionValue.value.trim());
                inputDescripcionValue.remove();
            }
        }
    });
});