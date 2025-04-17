<?php
//Va hacia Index
function irLanding()
{
    header("Location: ../vista/landing.php");
}
//Introduce un usuario y te envia a la lista
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
//Maneja las acciones enviadas por el usuario
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    $action();
} else {
    header("Location: ./normal.php?action=irLanding");
}
?>
