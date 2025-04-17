document.addEventListener("DOMContentLoaded", function () {
    const fotoInput = document.getElementById('fotoInput');
    const imgTag = document.getElementById('imgTag');
    const formulario = document.getElementById('formularioModUser');

    fotoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.onload = (event) => {
            imgTag.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });



    formulario.addEventListener('submit', function (event) {
        let arrayValidado = isValidFormContent();
        if (!arrayValidado["estado"]) {
            event.preventDefault(); // Prevent the form from submitting
        }
    });
    //Hace un chequeo de que todos los datos estan bien, si alguno falla devuelve false
    function isValidFormContent() {
        const datos = new FormData(formulario);
        const contraRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let arrayValidado = {
            "estado": true,
            "msj": ""
        }
        // let regex = new RegExp("^[a-zA-Z0-9]{3,16}$");

        // Consigue los datos del formulario
        let valores = {};
        for (const [key, value] of datos.entries()) {
            valores[key] = value;
        }
        if (valores["nom"].length < 5) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "El nombre debe tener minimo 5 caracteres.\n";
        }
        if (valores["contra"].length < 8){
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "El nombre debe tener minimo 8 caracteres.\n";
        }
        if (contraRegex.test(valores["contra"]) == false) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "La contraseña tiene que tener al menos 1 numero, 1 mayuscula, 1 minuscula y 8 caracteres.\n";
        }
        if (emailRegex.test(valores["mail"]) == false) {
            arrayValidado["estado"] = false;
            arrayValidado["msj"] += "Formato de e-mail incorrecto.\n";
        }
        return arrayValidado;
    }
})