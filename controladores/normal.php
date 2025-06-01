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
    $contra2 = $_POST["contra2"];
    $mail = $_POST["mail"];
    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";
    if (preg_match($pattern, $contra1)) {
        if ($contra1 === $contra2) {
            echo "<script>alert('Todo bien');</script>";
            $usus->insertUser($nom, $contra1, $mail);
            header("Location: ../index.php");
        } else {
            echo "<script>alert('Las contreseñas tienen que ser iguales.');</script>";
            header("Location: ../vista/introUser.php?action=Uno");
        }
    } else {
        echo "<script>alert('La contraseña tiene que tener al menos 1 numero, 1 mayuscula, 1 minuscula y 8 caracteres');</script>";
        header("Location: ../vista/introUser.php?action=Dos");
    }
}
//Ir a la modificación de un usuario
function irModUser(){
    session_start();
    $usuario = $_SESSION['user'];
    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");
    $datos=$usus->getDatos($usuario);
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

        // Only allow image extensions
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
    $usuario = $_SESSION['user'] ?? null;
    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");
    $role = $usus->getRole($usuario);

    if ($usuario) {
        header('Content-Type: application/json');
        $datos=array(
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
//Descargar foto
function descargarFoto()
{
    $uploadPath = '';

    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['portada']['tmp_name'];
        $originalName = basename($_FILES['portada']['name']);
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $newFileName = uniqid('portada_', true) . '.' . $ext;

        $uploadDir = '../images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpName, $destination)) {
            $uploadPath = $destination;
            $data['portada_path'] = $uploadPath;
        } else {
            die('Error al mover el archivo subido.');
        }
    }

    session_start();
    $_SESSION["nombre"] = $_POST["nombre"];
    $_SESSION["juego"] = $_POST["juego"];
    $_SESSION["numeroJugadores"] = $_POST["numeroJugadores"];
    $_SESSION["fechaInicio"] = $_POST["fechaInicio"];
    $_SESSION["descripcion"] = $_POST["descripcion"];
    $_SESSION["portada_path"] = $uploadPath;
    header("Location: ./normal.php?action=irMapa");
}
//Ir al mapa
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
    $nombre = $_SESSION["nombre"];
    $juego = $_SESSION["juego"];
    $numJugadores = $_SESSION["numeroJugadores"];
    $fechaInicio = $_SESSION["fechaInicio"];
    $descripcion = $_SESSION["descripcion"];
    $latitud = $_POST["lat"];
    $longitud = $_POST["lng"];
    $ciudad = $_POST["city"];
    $portada_path = $_SESSION["portada_path"];

    unset($_SESSION["nombre"]);
    unset($_SESSION["juego"]);
    unset($_SESSION["numeroJugadores"]);
    unset($_SESSION["fechaInicio"]);
    unset($_SESSION["descripcion"]);
    unset($_SESSION["portada_path"]);
    require_once("../classes/partida.php");
    $partida = new partida("../../../");
    $partida->crearPartida($nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $portada_path);

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
    $datos = $partida->buscarPartidas($lat,$lon);
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
function buscarMensajes(){
    header('Content-Type: application/json');
    $idPartida = $_POST['id'];
    require_once("../classes/foroMensaje.php");
    $foro = new foroMensaje("../../../");
    $datos = $foro->buscarMensajes($idPartida);
    echo json_encode($datos);
}
//Crear un mensaje en un foro
function crearMensajeForo(){
    header('Content-Type: application/json');
    $idPartida = $_POST['id'];
    $texto = $_POST['texto'];
    require_once("../classes/foroMensaje.php");
    $foro = new foroMensaje("../../../");
    $datos = $foro->crearMensajeForo($texto,$idPartida);
    echo json_encode($datos);
}
// BLOQUEO Y REPORTES
//Bloquear Usuario
function bloquearUsuario(){
    $nombreBloqueado = $_POST['nombreBloqueado'];
    require_once("../classes/bloqueado.php");
    $bloc = new bloqueado("../../../");
    $bloc->crearBloqueo($nombreBloqueado);
}
//Desbloquear Usuario
function desbloquearUsuario(){
    $nombreBloqueado = $_POST['nombreBloqueado'];
    require_once("../classes/bloqueado.php");
    $bloc = new bloqueado("../../../");
    $bloc->desbloquear($nombreBloqueado);
}

//CHAT PRIVADOS
//Ir a un chat privado
function irListaChatPrivado(){
    header("Location: ../vista/listaChatPrivado.php");
}
function irChatPrivado(){
    $nomUsuario = $_REQUEST['usuarioNom'];
    require_once("../classes/chatPrivado.php");
    $chat = new chatPrivado("../../../"); 
    $idChat = $chat->checkExistenciaChat($nomUsuario);
    require_once("../vista/header.php");
    require_once("../vista/chatPrivado.php");
    require_once("../vista/footer.php");
}
// Crear un mensaje en un chat privado
function crearMensajePrivado(){
    $texto = $_POST['texto'];
    $idPrivado = $_POST['id'];
    require_once("../classes/mensajesPrivados.php");
    $mensajes = new mensajesPrivados("../../../");
    $mensajes->crearMensajePrivado($texto, $idPrivado);
}
// Buscar los mensajes de un chat privado
function buscarMensajesPrivados(){
    header('Content-Type: application/json');
    $idPrivado = $_POST['id'];
    require_once("../classes/mensajesPrivados.php");
    $mensajes = new mensajesPrivados("../../../");
    $datos = $mensajes->buscarMensajesPrivados($idPrivado);
    echo json_encode($datos);
}
// Buscar los chats privados del usuario
function buscarChatsPrivados(){
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
