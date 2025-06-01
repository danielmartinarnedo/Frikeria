document.addEventListener("DOMContentLoaded", function () {
    const imgTag = document.getElementById('imgTag');
    const inputNombre = document.getElementsByName('nom')[0];
    const inputMail = document.getElementsByName('mail')[0];
    const inputContra = document.getElementsByName('contra')[0];
    const inputContra2 = document.getElementsByName('contra2')[0];
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
        if (inputContra.value.trim() !== inputContra2.value.trim()) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "Las contraseñas no coinciden.\n";
        }
        if (!emailRegex.test(inputMail.value.trim())) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "Formato de e-mail incorrecto.\n";
        }

        return arrayValidado;
    }

    function crearUsuario() {
        const validacion = validacionFormulario();
        if (!validacion.estado) {
            alert(validacion.msj);
        }else{
            const formularioDatos = new FormData();
            formularioDatos.append('nom', inputNombre.value.trim());
            formularioDatos.append('mail', inputMail.value.trim());
            formularioDatos.append('contra', inputContra.value.trim());

            fetch('../controladores/normal.php?action=insertarUsuario', {
                method: 'POST',
                body: formularioDatos
            })
            .then(response => response.json())
            .then(data => {
                if (data.estado) {
                    window.location.href = '../index.php';
                } else {
                    alert(data.msj);
                }
            })
            .catch(error => {
                console.error('Error al crear el usuario:', error);
                alert("Ocurrió un error al crear el usuario.");
            });
        }
    }

    submitForm.addEventListener('click', (e) => {
        crearUsuario();
    });
});