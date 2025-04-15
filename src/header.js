document.addEventListener("DOMContentLoaded", function () {
    usuarioDiv=document.getElementById("usuarioHeader");
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
                
            }
        });
})   