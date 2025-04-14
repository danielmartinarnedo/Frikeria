<?php
    //Ir a modUser
    function irMod(){
        $nom = $_REQUEST["nom"];
        require_once('../vista/admin/modUser.php');
    }
    //Ir a introUser
    function irIntro(){
        header("Location: ../vista/admin/introUser.php");
    }
    //Modica los datos de un usuario y te envia a la lista de este
    function modificar(){
        $nom = $_POST["nom"];
        $contra = $_POST["contra"];
        require_once("../classes/usuario.php");
        $usus = new usuario("../../../");
        $id=$usus->getId($_REQUEST["valor"]);
        $usus->modUser($nom, $contra,$id);
        header("Location: ./admin.php?action=irLista");
    }
    //Introduce un usuario y te envia a la lista
    function insertar(){
        $nom = $_POST["nom"];
        $contra = $_POST["contra"];
        require_once("../classes/usuario.php");
        $usus = new usuario("../../../");
        $usus->insertUser($nom, $contra);
        header("Location: ./admin.php?action=irLista");
    }
    //Busca usuarios con nombres que contengan la string introducida
    function buscar(){
        $busqueda = $_POST["nom"];
        require_once("../classes/usuario.php");
        $usus = new usuario("../../../");
        $datos = $usus->busquedaUser($busqueda);
        require_once('../vista/admin/busquedaUser.php');
    }
    //Ir a la lista
    function irLista(){
        require_once('../classes/usuario.php');
        $usus = new usuario("../../../");
        $datos = $usus->listUser();
        require_once('../vista/admin/listaUser.php');
    }
    //Maneja las acciones enviadas por el usuario
    if (isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
        $action();
    }else{
        header("Location: ./admin.php?action=irLista");
    }
?>