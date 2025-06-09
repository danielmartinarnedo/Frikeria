document.addEventListener("DOMContentLoaded", function () {
    const imgTag = document.getElementById('imgTag');
    const inputNombre = document.getElementsByName('nom')[0];
    const inputMail = document.getElementsByName('mail')[0];
    const inputContra = document.getElementsByName('contra')[0];
    const inputFoto = document.getElementsByName('foto')[0];
    const submitForm = document.getElementsByName('enviar')[0];
    
    // Funcion que valida el formulario
    function validacionFormulario() {
        const contraRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let arrayValidado = {
            "estado": true,
            "msj": ""
        };

        if (inputNombre.value.trim().length < 5) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "El nombre debe tener minimo 5 caracteres.\n";
        }else if (inputNombre.value.trim().length > 20) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "El nombre debe tener maximo 20 caracteres.\n";
        }
        if (inputContra.value.trim().length < 8) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "El nombre debe tener minimo 8 caracteres.\n";
        }
        if (!contraRegex.test(inputContra.value.trim())) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "La contraseña tiene que tener al menos 1 numero, 1 mayuscula, 1 minuscula y 8 caracteres.\n";
        }
        if (!emailRegex.test(inputMail.value.trim())) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "Formato de e-mail incorrecto.\n";
        }

        // Valida si el archivo seleccionado es una imagen
        const fotoFile = inputFoto.files[0];
        if (fotoFile && !fotoFile.type.startsWith('image/')) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "No has seleccionado un archivo de imagen válido.\n";
        }

        return arrayValidado;
    }

    function modificarUsuario() {
        const validacion = validacionFormulario();
        if (!validacion.estado) {
            alert(validacion.msj);
        }else{
            const formularioDatos = new FormData();
            formularioDatos.append('nom', inputNombre.value.trim());
            formularioDatos.append('mail', inputMail.value.trim());
            formularioDatos.append('contra', inputContra.value.trim());
            formularioDatos.append('foto', inputFoto.files[0]);

            fetch('../controladores/normal.php?action=modUsuario', {
                method: 'POST',
                body: formularioDatos
            })
            .then(response => response.json())
            .then(data => {
                if (data.estado) {
                    alert("Usuario modificado correctamente.");
                } else {
                    alert(data.msj);
                }
            })
            .catch(error => {
                console.error('Error al modificar el usuario:', error);
                alert("Ocurrió un error al modificar el usuario.");
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
            };
            reader.readAsDataURL(file);
        }
    });

    submitForm.addEventListener('click', (e) => {
        modificarUsuario();
    });
});