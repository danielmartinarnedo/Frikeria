<?php
ini_set('display_errors', 0); // oculta errores en la salida
ini_set('log_errors', 1); // activa log
ini_set('error_log', __DIR__ . '/errores.log'); // archivo donde se guardan errores

function irAdminIncio()
{
    header("Location: ../vista/admin.php");
}
function getTickets()
{
    header('Content-Type: application/json');
    require_once("../classes/reportes.php");
    $reportes = new reportes("../../../");
    $anuncios = $reportes->getTicketsAnuncio();
    $chatsForo = $reportes->getTicketsChatForo();
    $chatsPrivados = $reportes->getTicketsChatPrivado();
    $usuarios = $reportes->getTicketsUsuario();
    $tickets = array_merge($anuncios, $chatsForo, $chatsPrivados, $usuarios);
    echo json_encode($tickets);
}
function quitarTicket()
{
    header('Content-Type: application/json');
    require_once("../classes/reportes.php");
    $reportes = new reportes("../../../");
    $id = $_REQUEST["id"];
    $tipo = $_REQUEST["tipo"];

    $res = ["estado" => false, "mensaje" => "Ha habido un error al quitar el ticket de tipo $tipo"];
    switch ($tipo) {
        case 'anuncio':
            $res["estado"] = $reportes->quitarTicketAnuncio($id);
            break;
        case 'chatForo':
            $res["estado"] = $reportes->quitarTicketChatForo($id);
            break;
        case 'chatPrivado':
            $res["estado"] = $reportes->quitarTicketChatPrivado($id);
            break;
        case 'usuario':
            $res["estado"] = $reportes->quitarTicketUsuario($id);
            break;
        default:
            $res["mensaje"] = "Tipo de ticket no reconocido: $tipo";
            break;
    }
    if ($res["estado"]) {
        $res["mensaje"] = "Ticket eliminado correctamente.";
    }

    echo json_encode($res);
}

//Maneja las acciones enviadas por el usuario
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    $action();
} else {
    header("Location: ./admin.php?action=irAdminIncio");
}
