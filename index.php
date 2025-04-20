<?php
    //Maneja el inicio de sesion
    function inicio(){
        if(isset($_POST["fIni"])){
            require_once('modelo.php');
            require_once('classes/usuario.php');

            $usus = new usuario("../../");
            
            if(!isset($_POST["rec"]))
                unset_cookie("usuario");

            if($usus->compCrede($_POST["nom"], $_POST["contra"])){
                if(isset($_POST["rec"]))
                    set_cookie("usuario", $_POST["nom"]);
                    set_session('user', $_POST["nom"]);
                separador();
            }else{
                header('./vista/login.php');
            }
        }
    }
    //Separa el usuario del admin y el normal
    function separador(){
        require_once('classes/usuario.php');

        $usus = new usuario("../../");
        if($usus->compAdmin(get_session('user'))){
            header("Location: controladores/admin.php");
        }else{
            header("Location: controladores/normal.php");
        }
    }

    //Manejo de las acciones del usuario
    if(isset($_REQUEST["action"])){
        $action = $_REQUEST["action"];
        $action();
    }else{
        require_once('modelo.php');
        if(is_session('user')){ 
            separador();
        }else{
            header("Location: vista/landing.php");
        }
    }
?>