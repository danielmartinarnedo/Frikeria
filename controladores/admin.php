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