document.addEventListener('DOMContentLoaded', () => {
    const carta = document.querySelector('.card-body');
    const valoresInput = document.querySelectorAll('input[type="hidden"]');
    const partida = {};
    valoresInput.forEach(input => {
        partida[input.name] = input.value;
        input.parentNode.removeChild(input);
    });

    fetch('../controladores/normal.php?action=conseguirUsuario', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data !== null) {
                if (data.nombre.toLowerCase().trim() === partida.creador.toLowerCase().trim()) {
                    const enlace = document.createElement('a');
                    enlace.className = 'btn col-12 mt-3 mb-3 btn-success';
                    enlace.textContent = 'MODIFICAR PARTIDA';
                    enlace.href = `./modPartida.php?titulo=${encodeURIComponent(partida.titulo)}&juego=${encodeURIComponent(partida.juego)}&jugadores=${encodeURIComponent(partida.jugadores)}&fecha=${encodeURIComponent(partida.fecha)}&ciudad=${encodeURIComponent(partida.ciudad)}&descripcion=${encodeURIComponent(partida.descripcion)}&portada=${encodeURIComponent(partida.portada)}&foro=${encodeURIComponent(partida.foro)}&creador=${encodeURIComponent(partida.creador)}`;
                    carta.appendChild(enlace);
                } else {
                    const boton = document.createElement('button');
                    boton.className = 'btn col-12 mt-3 mb-3 btn-danger';
                    boton.textContent = 'REPORTAR PARTIDA';
                    //Poner aqui el evento para reportar la partida
                    carta.appendChild(boton);
                }
            } else {
                console.error('Error al obtener el usuario:', data);
            }
        });
});