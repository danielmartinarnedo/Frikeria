<?php
session_start(); // Inicia la sesión si no está iniciada
//Consigue el nombre del usuario
function conseguirUsuario()
{
    $usuario = $_SESSION['user'] ?? null;

    if ($usuario) {
        header('Content-Type: application/json');
        echo json_encode($usuario);
    } else {
        header('Content-Type: application/json');
        echo json_encode(null);
    }
}
//Ir a la Modificacion de Usuario
function irModUser(){
    $usuario = $_SESSION['user'];
    require_once("../classes/usuario.php");
    $usus = new usuario("../../../");
    $datos=$usus->getDatos($usuario);
    require_once("../vista/modUser.php");
}
//Cerrar Session
function cerrarSes()
{
    require_once("../modelo.php");
    unset_session("user");
    header("Location: ../vista/landing.php");
}

// Deriva las acciones del js a las funciones necesarias
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];

    if (function_exists($action)) {
        $action();
    } else {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Function '$action' not found"]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "No action specified"]);
}
