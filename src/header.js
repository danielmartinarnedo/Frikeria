document.addEventListener("DOMContentLoaded", function () {
  headerDiv = document.getElementById("menuHeader");
  ruta = `../controladores/normal.php?action=`;
  fetch(ruta + "conseguirUsuario", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
  })
    .then(res => res.json())
    .then(data => {
      if (data !== null) {
        if (data.role) {
          const navbarBrand = document.querySelector('.navbar-brand');
          headerDiv.innerHTML = `
            <li class="nav-item ms-3"><a class="nav-link" href="${ruta + 'irModUser'}">MODIFICAR DATOS</a></li>
            <li  class="nav-item ms-3"><a class="nav-link" href="${ruta + 'cerrarSes'}">CERRAR SESIÓN</a></li>`;
          navbarBrand.href = `..vista/admin.php`;
        } else {
          headerDiv.innerHTML = `
                        <li class="nav-item ms-3">
          <a class="nav-link" href="${ruta + 'irListaChatPrivado'}">MENSAJES</a>
        </li>

        <li class="nav-item dropdown ms-3">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            PARTIDAS
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="${ruta + 'irCrearPartida'}">CREAR PARTIDA</a></li>
            <li><a class="dropdown-item" href="${ruta + 'irlistaPartidasPropias'}">MIS PARTIDA</a></li>
            <li><a class="dropdown-item" href="${ruta + 'irBuscarPartida'}">BUSCAR PARTIDA</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown ms-3 me-3">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            ${data.nombre.toUpperCase()}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="${ruta + 'irModUser'}">MODIFICAR DATOS</a></li>
            <li><a class="dropdown-item" href="${ruta + 'cerrarSes'}">CERRAR SESIÓN</a></li>
          </ul>
        </li>
                `;
        }
      }
    });
})   
