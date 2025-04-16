document.addEventListener("DOMContentLoaded", function () {
    usuarioDiv = document.getElementById("usuarioHeader");
    fetch(`/Frikeria/controladores/src.php?action=conseguirUsuario`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data !== null) {
                usuarioDiv.innerHTML = `
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Right-aligned menu example</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item" type="button">Action</button></li>
                        <li><button class="dropdown-item" type="button">Another action</button></li>
                        <li><button class="dropdown-item" type="button">Something else here</button></li>
                    </ul>
                </div>
                `;

            }
        });
})   