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

//Ir al mapa
function irMapa(){
    require_once("../vista/crearPartidaMapa.php");
}
//Crear una partida y te manda a la landing
function crearPartida()
{
    // $nombre = $_POST["nombre"];
    // $juego = $_POST["juego"];
    // $numJugadores = $_POST["numeroJugadores"];
    // $fechaInicio = $_POST["fechaInicio"];
    // $portada = null;
    // // Check if the file was uploaded
    // if (isset($_FILES['portada'])) {
    //     // Get the file information
    //     $fotodata = $_FILES['portada'];
    //     $portada = $_FILES["portada"]["tmp_name"];

    //     // Get the file name and extension
    //     $fileName = $fotodata['name'];
    //     $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    //     // Check if the file is an image
    //     if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
    //         // Get the file path
    //         $filePath = "../images/" . $fileName;

    //         // Move the file to the images directory
    //         if (move_uploaded_file($fotodata['tmp_name'], $filePath)) {
    //             echo "File uploaded successfully!";
    //         } else {
    //             echo "Error uploading file!";
    //         }
    //     } else {
    //         echo "Only image files are allowed!";
    //     }
    // }
    // require_once("../classes/partida.php");
    // $partida = new partida("../../../");
    // $partida->crearPartida($nombre, $juego, $numJugadores, $fechaInicio, $portada);
    header("Location: ../index.php");
}

//Maneja las acciones enviadas por el usuario
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    $action();
} else {
    header("Location: ./normal.php?action=irLanding");
}
