<?php
class foroMensaje
{
    private $db;
    public function __construct($barritas)
    {
        // require_once ($barritas.'cred.php');
        // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
        $this->db = new mysqli("localhost", "root", "", "frikeria");
    }
    //Crear una partida
    public function crearMensajeForo($texto, $id_anuncio)
    {
        require_once("../classes/usuario.php");
        session_start();
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $sentencia = "INSERT INTO foromensaje (idUser, idAnuncio, texto) VALUES (?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("iis", $id_user, $id_anuncio, $texto);
        $consulta->execute();
        $consulta->close();
    }
    public function buscarMensajes($id_anuncio)
    {
        $sentencia = "SELECT * FROM foromensaje WHERE idAnuncio = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id_anuncio);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $mensajes = array();
        while ($datos = $resultado->fetch_assoc()) {
            array_push($mensajes, $datos);
        }
        return $mensajes;
    }
}
