<?php
    //Guarda una cookie
    function set_cookie(String $nom, $val){
        setcookie($nom, $val, time()+(86400*30));
    }
    //Quita una cookie
    function unset_cookie(String $nom){
        $comp = false;

        if(isset($_COOKIE[$nom])){
            setcookie($nom, '', time()-30);
            $comp = true;
        }

        return $comp;
    }

    //Inicia la sesion
    function start_session(){
        if(session_status() === PHP_SESSION_NONE)
            session_start();
    }
    //Guarda los datos de una sesion
    function set_session(String $nom, $val){
        start_session();
        $_SESSION[$nom] = $val;
    }
    //Coge los datos de una sesion
    function get_session(String $nom){
        start_session();
        return $_SESSION[$nom];
    }
    //Elimina los datos de una sesion
    function unset_session(){
        start_session();
        session_unset();
        session_destroy();
    }
    //Checkea si hay una sesion
    function is_session(String $nom){
        start_session();
        $isset = isset($_SESSION[$nom]);

        return $isset;
    }
?>