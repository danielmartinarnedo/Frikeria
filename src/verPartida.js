document.addEventListener('DOMContentLoaded', () => {
    const carta = document.querySelector('.card-body');
    const valoresInput = document.querySelectorAll('input[type="hidden"]');
    const modalReporte = new bootstrap.Modal(document.getElementById('reportModal'));
    const reportarBoton = document.getElementById('reportarBoton');
    const reporteDescripcion = document.getElementById('reporteDescripcion');
    const partida = {};
    valoresInput.forEach(input => {
        partida[input.name] = input.value;
        input.remove();
    })

    fetch('../controladores/normal.php?action=conseguirUsuario', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data !== null) {
                if (!partida.creador || data.nombre.toLowerCase().trim() === partida.creador.toLowerCase().trim()) {
                    const enlace = document.createElement('a');
                    enlace.className = 'btn col-12 mt-3 mb-3 btn-success';
                    enlace.textContent = 'MODIFICAR PARTIDA';
                    enlace.href = `./modPartida.php?titulo=${encodeURIComponent(partida.titulo)}&juego=${encodeURIComponent(partida.juego)}&jugadores=${encodeURIComponent(partida.jugadores)}&fecha=${encodeURIComponent(partida.fecha)}&ciudad=${encodeURIComponent(partida.ciudad)}&descripcion=${encodeURIComponent(partida.descripcion)}&portada=${encodeURIComponent(partida.portada)}&foro=${encodeURIComponent(partida.foro)}&lat=${partida.lat}&lng=${partida.lng}`;
                    carta.appendChild(enlace);
                } else {
                    const boton = document.createElement('button');
                    boton.className = 'btn col-12 mt-3 mb-3 btn-danger';
                    boton.textContent = 'REPORTAR PARTIDA';
                    carta.appendChild(boton);

                    boton.addEventListener('click', () => {
                        modalReporte.show();
                    });
                }
            } else {
                console.error('Error al obtener el usuario:', data);
            }
        });
    reportarBoton.addEventListener('click', () => {
        if (reporteDescripcion.value.trim()) {
            fetch('../controladores/normal.php?action=reportarPartida', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    idPartida: partida.foro,
                    descripcion: reporteDescripcion.value
                })
            })
        .catch(error => {
            console.error('Error al enviar el reporte:', error);
            alert('Ocurrió un error al enviar el reporte. Por favor, inténtalo de nuevo más tarde.');
        });
        modalReporte.hide();
}else {
    alert('Por favor, ingresa una descripción para el reporte.');
}
    });
});