<?php
session_start(); // Ensure session is started before accessing $_SESSION

function conseguirUsuario()
{
    $usuario = $_SESSION['user'] ?? null;

    if ($usuario) {
        require_once("../classes/usuario.php");
        $usus = new usuario("../../../");
        $datos = $usus->getUser($usuario);

        header('Content-Type: application/json');
        echo json_encode($datos);
    } else {
        header('Content-Type: application/json');
        echo json_encode(null);
    }
}

// Handle actions from JavaScript
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];

    if (function_exists($action)) {
        $action(); // call the function
    } else {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Function '$action' not found"]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "No action specified"]);
}
