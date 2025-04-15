<?php
    //Va hacia Index
    function irIndex(){
        header("Location: ../vista/normal/index.php");
    }
      //Introduce un usuario y te envia a la lista
      function insertarUsuario(){
        $nom = $_POST["nom"];
        $contra1 = $_POST["contra"];
        $contra2 = $_POST["contra2"];
        $mail = $_POST["mail"];
        require_once("../classes/usuario.php");
        $usus = new usuario("../../../");
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,128}$/";
        if (preg_match($pattern, $contra1)) {
            if ($contra1 != $contra2) {
                $usus->insertUser($nom, $contra, $mail);
                header("Location: ../vista/normal/index.php");
            }else {
                echo "<script>alert('Las contreseñas tienen que ser iguales.');</script>";
            } 
        } else {
            echo "<script>alert('La contraseña tiene que tener al menos 1 numero, 1 mayuscula, 1 minuscula y 8 caracteres');</script>";
        }
        header("Location: ../vista/normal/introUser.php");
        
    }
    //Cerrar Session
    function cerrarSes(){
        require_once("../modelo.php");
        unset_session("user");
        header("Location: ../vista/normal/index.php");
    }
    //Maneja las acciones enviadas por el usuario
    if (isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
        $action();
    }else{
        header("Location: ./normal.php?action=irIndex");
    }
?>