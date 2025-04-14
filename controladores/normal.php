<?php
    //Va hacia Index
    function irIndex(){
        header("Location: ../vista/admin/index.php");
    }
    //Cerrar Session
    function cerrarSes(){
        require_once("../modelo.php");
        unset_session("user");
        header("Location: ../vista/login.php");
    }
    //Maneja las acciones enviadas por el usuario
    if (isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
        $action();
    }else{
        header("Location: ./normal.php?action=irIndex");
    }
    //Maneja los errores de las imagenes
    if (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case 'archivo_no_imagen':
                echo "<script>alert('El archivo debe ser una imagen. Redireccionandote a la anterior lista.');</script>";
                break;
            case 'archivo_no_subido':
                echo "<script>alert('Algo ha ido mal al subir el archivo. Redireccionandote a la anterior lista.');</script>";
                break;
        }
    }
?>