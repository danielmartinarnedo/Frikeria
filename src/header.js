document.addEventListener("DOMContentLoaded", function () {
    usuarioDiv = document.getElementById("usuarioHeader");
    ruta = `../controladores/src.php?action=`;
    fetch(ruta+"conseguirUsuario", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
    })
        .then(res => res.json())
        .then(data => {
            if (data !== null) {
                usuarioDiv.innerHTML = `
                <div class="btn-group nav-item">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        ${data}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="${ruta+"irModUser"}">Modificar Datos</a></li>
                        <li><a class="dropdown-item" href="${ruta+"cerrarSes"}">Cerrar Sesion</a></li>
                    </ul>
                </div>
                `;

            }
        });
})   