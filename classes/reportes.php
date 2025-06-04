<?php
class reportes
{
    private $db;
    public function __construct($barritas)
    {
        // require_once ($barritas.'cred.php');
        // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
        $this->db = new mysqli("localhost", "root", "", "frikeria");
    }
    function crearReportePartida($id, $descripcion)
    {
         $sentencia = "INSERT INTO reportepartidaanuncio (idPartida, descripcion) VALUES (?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("is", $id, $descripcion);
        $resultado = $consulta->execute();
        $consulta->close();
    }
    function crearReporteUsuario($id, $descripcion)
    {
         $sentencia = "INSERT INTO reporteusuario (idUsuario, descripcion) VALUES (?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("is", $id, $descripcion);
        $resultado = $consulta->execute();
        $consulta->close();
    }
    function crearReporteForo($idChat, $idMensaje, $descripcion)
    {
         $sentencia = "INSERT INTO reporteforomensaje (idChat, idMensaje, descripcion) VALUES (?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("iis", $idChat, $idMensaje, $descripcion);
        $resultado = $consulta->execute();
        $consulta->close();
    }
    function crearReporteChatPrivado($idChat, $idMensaje, $descripcion)
    {
         $sentencia = "INSERT INTO reportechatprivado (idChat, idMensaje, descripcion) VALUES (?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("iis", $idChat, $idMensaje, $descripcion);
        $resultado = $consulta->execute();
        $consulta->close();
    }
}
?>