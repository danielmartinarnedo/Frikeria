<?php
    function conseguirUsuario(){
        $usuario=$_SESSION['user'];
        if (isset($usuario)) {
            require_once("../classes/usuario.php");
        } else {
            return $usuario;
        }
        
    }
    
    //Maneja las acciones enviadas por el javascript
    if (isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
        $action();
    }else{
        echo "<script>alert('ACCION NO ENCONTRADA');</script>";
    }
?>