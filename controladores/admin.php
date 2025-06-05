<?php
ini_set('display_errors', 0); // oculta errores en la salida
ini_set('log_errors', 1); // activa log
ini_set('error_log', __DIR__ . '/errores.log'); // archivo donde se guardan errores
//Funcion que redirige al inicio del administrador
function irAdminIncio()
{
    header("Location: ../vista/admin.php");
}
// Funcion que consigue todos los tickets de la base de datos
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
// Funcion que hacer que finiquita un ticket de la base de datos
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
// Funcion que redirige a la vista de administracion de usuarios
function irAdminUsuario()
{
    require_once("../vista/header.php");
    require_once("../vista/adminUsuario.php");
    require_once("../vista/footer.php");
}
// Funcion que obtione los datos de un usuario para mostrarlos en la vista de administracion de usuarios
function getDatosUsuario()
{
    header('Content-Type: application/json');
    require_once("../classes/usuario.php");
    $usuario = new usuario("../../../");
    $id = $_POST["id"];
    $datosUsuario = $usuario->getDatosForoUsuario($id);
    echo json_encode($datosUsuario);
}
// Funcion que quita acceso a un usuario y todos los tickets relacionado a ese usuario
function sentenciarTicketUsuario()
{
    header('Content-Type: application/json');
    $idUsuario = $_POST["idUsuario"];
    require_once("../classes/usuario.php");
    $usuario = new usuario("../../../");
    $res = $usuario->quitarUsuario($idUsuario);
    if ($res) {
        require_once("../classes/reportes.php");
        $reportes = new reportes("../../../");
        $res = $reportes->quitarTodosTicketUsuario($idUsuario);
        if ($res) {
            $res = ["estado" => true, "mensaje" => "El usuario ha sido sentenciado correctamente."];
        } else {
            $res = ["estado" => false, "mensaje" => "Ha habido un error al sentenciar el ticket."];
        }
    } else {
        $res = ["estado" => false, "mensaje" => "Ha habido un error al eliminar el usuario."];
    }
    echo json_encode($res);
}
// Funcion que redirige a la vista de administracion de anuncios y coje el anuncio de la base de datos
function irAdminAnuncio()
{
    require_once("../classes/partida.php");
    $anuncio = new partida("../../../");
    $idPartida = $_POST["idPartida"];
    $anuncio = $anuncio->getPartida($idPartida);
    require_once("../vista/header.php");
    require_once("../vista/adminVerPartida.php");
    require_once("../vista/footer.php");
}
// Funcion que quita anuncios de la base de datos
function sentenciarTicketPartida()
{
    header('Content-Type: application/json');
    $idPartida = $_POST["idPartida"];
    require_once("../classes/partida.php");
    $partida = new partida("../../../");
    $res = $partida->quitarPartida($idPartida);
    if ($res) {
        require_once("../classes/reportes.php");
        $reportes = new reportes("../../../");
        $res = $reportes->quitarTodosTicketPartida($idPartida);
        if ($res) {
            $res = ["estado" => true, "mensaje" => "El anuncio ha sido sentenciado correctamente."];
        } else {
            $res = ["estado" => false, "mensaje" => "Ha habido un error al sentenciar el ticket."];
        }
    } else {
        $res = ["estado" => false, "mensaje" => "Ha habido un error al sentenciar el ticket."];
    }
    echo json_encode($res);
}
//Funcion para eliminar un mensaje del foro
function sentenciarTicketforoMensaje()
{
    header('Content-Type: application/json');
    $idMensaje = $_POST["idMensaje"];
    require_once("../classes/foroMensaje.php");
    $foro = new foroMensaje("../../../");
    $res = $foro->quitarMensaje($idMensaje);
    if ($res) {
        require_once("../classes/reportes.php");
        $reportes = new reportes("../../../");
        $res = $reportes->quitarTodosTicketForoMensaje($idMensaje);
        $res = ["estado" => true, "mensaje" => "El mensaje ha sido sentenciado correctamente."];
    } else {
        $res = ["estado" => false, "mensaje" => "Ha habido un error al sentenciar el ticket."];
    }
    echo json_encode($res);
}

// Funcion para ir al chat admin
function irAdminChatForo()
{
    require_once("../classes/foroMensaje.php");
    $foro = new foroMensaje("../../../");
    $mensajes = $foro->buscarMensajes($_POST["idChat"]);
    require_once("../vista/header.php");
    require_once("../vista/adminChatForo.php");
    require_once("../vista/footer.php");
}
//Maneja las acciones enviadas por el usuario
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    $action();
} else {
    header("Location: ./admin.php?action=irAdminIncio");
}
