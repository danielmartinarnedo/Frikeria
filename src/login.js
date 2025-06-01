document.addEventListener("DOMContentLoaded", function () {
    const inputNombre = document.getElementsByName('nom')[0];
    const inputContra = document.getElementsByName('contra')[0];
    const recCookies = document.getElementsByName('rec')[0];
    const submitForm = document.getElementsByName('enviar')[0];

    function inicioUsuario() {
        const formularioDatos = new FormData();
        formularioDatos.append('nom', inputNombre.value.trim());
        formularioDatos.append('rec', recCookies.value.trim());
        formularioDatos.append('contra', inputContra.value.trim());

        fetch('../controladores/normal.php?action=inicio', {
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

    submitForm.addEventListener('click', (e) => {
        inicioUsuario();
    });
});