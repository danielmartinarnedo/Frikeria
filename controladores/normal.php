<?php
//Va hacia Index
function irLanding()
{
    header("Location: ../vista/landing.php");
}
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

//Modifica el usuario y te manda a la landing
function modUsuario()
{
    $nom = $_POST["nom"];
    $contra = $_POST["contra"];
    $mail = $_POST["mail"];
    $foto = null;
    // Check if the file was uploaded
    if (isset($_FILES['foto'])) {
        // Get the file information
        $fotodata = $_FILES['picture'];
        $foto = $_FILES["foto"]["tmp_name"];

        // Get the file name and extension
        $fileName = $fotodata['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Check if the file is an image
        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Get the file path
            $filePath = "../images/" . $fileName;

            // Move the file to the images directory
            if (move_uploaded_file($fotodata['tmp_name'], $filePath)) {
                echo "File uploaded successfully!";
            } else {
                echo "Error uploading file!";
            }
        } else {
            echo "Only image files are allowed!";
        }
    }
    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");
    $usus->modUser($nom, $contra, $mail, $foto);
    header("Location: ../index.php");
}

//PARTIDAS
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
//Ir a Buscar partida
function irBuscarPartida()
{
    require_once("../vista/header.php");
    require_once("../vista/buscarPartida.php");
    require_once("../vista/footer.php");
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
    $idPrivado = $_POST['idPrivado'];
    require_once("../classes/mensajesPrivados.php");
    $mensajes = new mensajesPrivados("../../../");
    $mensajes->crearMensajePrivado($texto, $idPrivado);
}
function buscarMensajesPrivados(){
    header('Content-Type: application/json');
    $idPrivado = $_POST['idPrivado'];
    require_once("../classes/mensajesPrivados.php");
    $mensajes = new mensajesPrivados("../../../");
    $datos = $mensajes->buscarMensajesPrivados($idPrivado);
    echo json_encode($datos);
}
//Maneja las acciones enviadas por el usuario
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    $action();
} else {
    header("Location: ./normal.php?action=irLanding");
}
