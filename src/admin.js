document.addEventListener('DOMContentLoaded', function () {
    const selectTipo = document.getElementById('selectTipo');
    const ticketsContainer = document.getElementById('ticketsContainer');
    let objTickets = {};

    function cargarTicketsInit(objeto) {
        for (const [clave, valor] of Object.entries(objeto)) {
            cargarTickets(clave,valor);
        }
    }

function cargarTickets(clave, valor) {
    for (const [claveTicket, ticket] of Object.entries(valor)) {
        ticketsContainer.innerHTML +=
            `<div class="card col-12 mb-3" id="${clave}${claveTicket}">
                <div class="card-header">
                    <h4 class="card-title">TIPO DE TICKET: ${clave.toUpperCase()}</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">${ticket.descripcion}</p>
                </div>
                <div class="card-footer d-flex justify-content">
                    <button class="btn btn-success col-6 text-white me-1" id="quitar${clave}${claveTicket}">QUITAR TICKET</button>
                    <button class="btn btn-primary col-6 text-white" id="revisar${clave}${claveTicket}">REVISAR</button>
                </div>
            </div>`;
    }

    setTimeout(() => {
        for (const [claveTicket, ticket] of Object.entries(valor)) {
            // QUITAR TICKET
            document.getElementById(`quitar${clave}${claveTicket}`).addEventListener('click', function () {
                fetch('../controladores/admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'quitarTicket',
                        tipo: clave,
                        id: claveTicket
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.estado) {
                            document.getElementById(`${clave}${claveTicket}`).remove();
                            delete objTickets[clave][claveTicket];
                        } else {
                            alert('Error al quitar el ticket: ' + data.mensaje);
                        }
                    })
                    .catch(error => {
                        console.error('Error quitando el ticket:', error);
                    });
            });

            // REVISAR TICKET
            document.getElementById(`revisar${clave}${claveTicket}`).addEventListener('click', function () {
                const formularioDatos = new FormData();
                for (const [key, value] of Object.entries(ticket)) {
                    formularioDatos.append(key, value);
                }

                let action = '';
                switch (clave) {
                    case 'anuncio':
                        action = '../controladores/admin.php?action=irAdminAnuncio';
                        break;
                    case 'chatForo':
                        action = '../controladores/admin.php?action=irAdminChatForo';
                        break;
                    case 'chatPrivado':
                        action = '../controladores/admin.php?action=irAdminChatPrivado';
                        break;
                    case 'usuario':
                        action = '../controladores/admin.php?action=irAdminUsuario';
                        break;
                    default:
                        console.warn(`No action defined for tipo: ${clave}`);
                        return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = action;

                for (const [key, value] of formularioDatos.entries()) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    form.appendChild(input);
                }

                document.body.appendChild(form);
                form.submit();
            });
        }
    }, 0);
}

    // Coge los tickets de la base de datos
    fetch('../controladores/admin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'getTickets',
        })
    }).then(response => response.json())
        .then(data => {
            objTickets = data;
            ticketsContainer.innerHTML += ``;
            cargarTicketsInit(objTickets)
        }).catch(error => {
            console.error('Error fetching tickets:', error);
        });
    // Seleciona el tipo de ticket
    selectTipo.addEventListener('change', function () {
        const tipoSeleccionado = selectTipo.value;
        ticketsContainer.innerHTML = ``;
        if (tipoSeleccionado === 'todo') {
            cargarTicketsInit(objTickets)
        } else {
            cargarTickets(tipoSeleccionado, objTickets[tipoSeleccionado]);
        }
    });
});