<?php
ini_set('display_errors', 0); // oculta errores en la salida
ini_set('log_errors', 1); // activa log
ini_set('error_log', __DIR__ . '/errores.log'); // archivo donde se guardan errores
//Va hacia Index
function irLanding()
{
    header("Location: ../vista/landing.php");
}
//USUARIO
//Introduce un usuario y te envia a la landing
function insertarUsuario()
{
    $nom = $_POST["nom"];
    $contra1 = $_POST["contra"];
    $mail = $_POST["mail"];
    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");
    if ($usus->compExistencia($nom)) {
        $usus->insertUser($nom, $contra1, $mail);
        session_start();
        $_SESSION['user'] = $nom;
        echo json_encode(["estado" => true, "msj" => "Usuario creado correctamente."]);
    } else {
        echo json_encode(["estado" => false, "msj" => "Nombre de usuario ya existe."]);
    }
}
//Ir a la modificación de un usuario
function irModUser()
{
    session_start();
    $usuario = $_SESSION['user'];
    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");
    $datos = $usus->getDatos($usuario);
    require_once("../vista/header.php");
    require_once("../vista/modUser.php");
    require_once("../vista/footer.php");
}

//Modifica el usuario y te manda a la landing
function modUsuario()
{
    $nom = $_POST["nom"];
    $contra = $_POST["contra"];
    $mail = $_POST["mail"];
    $foto = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotodata = $_FILES['foto'];
        $fileName = basename($fotodata['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Permitir solo ciertos tipos de archivos de imagen
        if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
            $filePath = "../images/" . $fileName;

            if (move_uploaded_file($fotodata['tmp_name'], $filePath)) {
                $foto = $filePath;
            } else {
                echo json_encode(["estado" => false, "msj" => "Error al subir la imagen."]);
                exit;
            }
        } else {
            echo json_encode(["estado" => false, "msj" => "Solo se permiten archivos de imagen (jpg, jpeg, png, gif)."]);
            exit;
        }
    }


    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");
    $usus->modUser($nom, $contra, $mail, $foto);

    echo json_encode(["estado" => true]);
}


//Consigue el usuario logueado y su rol
function conseguirUsuario()
{
    session_start();
    $usuario = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");

    if ($usuario !== null && $usuario !== "") {
        $role = $usus->getRole($usuario);
        header('Content-Type: application/json');
        $datos = array(
            'nombre' => $usuario,
            'role' => $role
        );
        echo json_encode($datos);
    } else {
        header('Content-Type: application/json');
        echo json_encode(null);
    }
}
//Cierra la sesión del usuario

function cerrarSes()
{
    require_once("../modelo.php");
    unset_session("user");
    header("Location: ../vista/landing.php");
}
//PARTIDAS
//Ir a la creación de una partida
function irCrearPartida()
{
    header("Location: ../vista/crearPartida.php");
}
//Ir a la busqueda de una partida
function irBuscarPartida()
{
    header("Location: ../vista/buscarPartida.php");
}
// Crea la foto de la partida y devuelve la ruta
function crearPartidaForm()
{
    $fotoRuta = null;

    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $fotodata = $_FILES['portada'];
        $fileName = basename($fotodata['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Permitir solo ciertos tipos de archivos de imagen
        if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
            $filePath = "../images/" . $fileName;

            if (move_uploaded_file($fotodata['tmp_name'], $filePath)) {
                $fotoRuta = $filePath;
            } else {
                echo json_encode(["estado" => false, "msj" => "Error al subir la imagen."]);
                exit;
            }
        } else {
            echo json_encode(["estado" => false, "msj" => "Solo se permiten archivos de imagen (jpg, jpeg, png, gif)."]);
            exit;
        }
    }

    echo json_encode(["estado" => true, "fotoRuta" => $fotoRuta]);
}
//Ir a la creación de una partida en el mapa
function irMapa()
{
    require_once("../vista/header.php");
    require_once("../vista/crearPartidaMapa.php");
    require_once("../vista/footer.php");
}
//Crear una partida y te manda a la landing
function crearPartida()
{
    session_start();
    $latitud = $_POST["lat"];
    $longitud = $_POST["lng"];
    $ciudad = $_POST["city"];
    $nombre = $_POST['nombre'];
    $juego = $_POST['juego'];
    $numJugadores = $_POST['numeroJugadores'];
    $fechaInicio = $_POST['fechaInicio'];
    $descripcion = $_POST['descripcion'];
    $fotoRuta = $_POST['fotoRuta'];

    require_once("../classes/partida.php");
    $partida = new partida("../../../");
    $partida->crearPartida($nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $fotoRuta);

    header("Location: ../index.php");
}
//Buscar partida
function buscarPartida()
{
    header('Content-Type: application/json');
    $lat = $_POST['lat'];
    $lon = $_POST['lng'];
    require_once("../classes/partida.php");
    $partida = new partida("../../../");
    $datos = $partida->buscarPartidas($lat, $lon);
    echo json_encode($datos);
}
//Buscar las partidas que ha creado el usuario
function buscarPartidasPropias()
{
    header('Content-Type: application/json');
    require_once("../classes/partida.php");
    $partida = new partida("../../../");
    $datos = $partida->buscarPartidasPropias();
    echo json_encode($datos);
}
//Ir a lista de partidas propias
function irlistaPartidasPropias()
{
    header("Location: ../vista/listaPartidasPropias.php");
}
//FORO
//Buscar los Mensajes de un foro
function buscarMensajes()
{
    header('Content-Type: application/json');
    $idPartida = $_POST['id'];
    require_once("../classes/foroMensaje.php");
    $foro = new foroMensaje("../../../");
    $datos = $foro->buscarMensajes($idPartida);
    echo json_encode($datos);
}
//Crear un mensaje en un foro
function crearMensajeForo()
{
    header('Content-Type: application/json');
    $idPartida = $_POST['id'];
    $texto = $_POST['texto'];
    require_once("../classes/foroMensaje.php");
    $foro = new foroMensaje("../../../");
    $datos = $foro->crearMensajeForo($texto, $idPartida);
    echo json_encode($datos);
}
// BLOQUEO Y REPORTES
//Bloquear Usuario
function bloquearUsuario()
{
    $nombreBloqueado = $_POST['nombreBloqueado'];
    require_once("../classes/bloqueado.php");
    $bloc = new bloqueado("../../../");
    $bloc->crearBloqueo($nombreBloqueado);
}
//Desbloquear Usuario
function desbloquearUsuario()
{
    $nombreBloqueado = $_POST['nombreBloqueado'];
    require_once("../classes/bloqueado.php");
    $bloc = new bloqueado("../../../");
    $bloc->desbloquear($nombreBloqueado);
}

//CHAT PRIVADOS
//Ir a un chat privado
function irListaChatPrivado()
{
    header("Location: ../vista/listaChatPrivado.php");
}
function irChatPrivado()
{
    $nomUsuario = $_REQUEST['usuarioNom'];
    require_once("../classes/chatPrivado.php");
    $chat = new chatPrivado("../../../");
    $idChat = $chat->checkExistenciaChat($nomUsuario);
    require_once("../vista/header.php");
    require_once("../vista/chatPrivado.php");
    require_once("../vista/footer.php");
}
// Crear un mensaje en un chat privado
function crearMensajePrivado()
{
    $texto = $_POST['texto'];
    $idPrivado = $_POST['id'];
    require_once("../classes/mensajesPrivados.php");
    $mensajes = new mensajesPrivados("../../../");
    $mensajes->crearMensajePrivado($texto, $idPrivado);
}
// Buscar los mensajes de un chat privado
function buscarMensajesPrivados()
{
    header('Content-Type: application/json');
    $idPrivado = $_POST['id'];
    require_once("../classes/mensajesPrivados.php");
    $mensajes = new mensajesPrivados("../../../");
    $datos = $mensajes->buscarMensajesPrivados($idPrivado);
    echo json_encode($datos);
}
// Buscar los chats privados del usuario
function buscarChatsPrivados()
{
    header('Content-Type: application/json');
    require_once("../classes/chatPrivado.php");
    $chat = new chatPrivado("../../../");
    $datos = $chat->buscarChatsPrivados();
    echo json_encode($datos);
}
//Maneja las acciones enviadas por el usuario
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    $action();
} else {
    header("Location: ./normal.php?action=irLanding");
}
