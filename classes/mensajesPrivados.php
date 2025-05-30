<?php
class mensajesPrivados
{
    private $db;
    public function __construct($barritas)
    {
        // require_once ($barritas.'cred.php');
        // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
        $this->db = new mysqli("localhost", "root", "", "frikeria");
    }
    public function crearMensajePrivado($texto, $id_anuncio)
    {
        require_once("../classes/usuario.php");
        session_start();
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $sentencia = "INSERT INTO mensajeschatprivado (idUser, idAnuncio, texto) VALUES (?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("iis", $id_user, $id_anuncio, $texto);
        $consulta->execute();
        $consulta->close();
    }
}
?>