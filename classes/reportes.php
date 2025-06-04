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
    function getTicketsAnuncio()
    {
        $sentencia = "SELECT * FROM reportepartidaanuncio WHERE resuelto = 0";
        $consulta = $this->db->query($sentencia);
        $tickets = [];
        $anuncioReportes = [];
        while ($fila = $consulta->fetch_assoc()) {
            $clave = "id" . $fila['id'];
            $anuncioReportes[$clave] = $fila;
        }
        $tickets['anuncio'] = $anuncioReportes;
        return $tickets;
    }
    function getTicketsChatForo()
    {
        $sentencia = "SELECT * FROM reporteforomensaje WHERE resuelto = 0";
        $consulta = $this->db->query($sentencia);
        $tickets = [];
        $chatForoReportes = [];
        while ($fila = $consulta->fetch_assoc()) {
            $clave = "id" . $fila['id'];
            $chatForoReportes[$clave] = $fila;
        }
        $tickets['chatForo'] = $chatForoReportes;
        return $tickets;
    }
    function getTicketsChatPrivado()
    {
        $sentencia = "SELECT * FROM reportechatprivado WHERE resuelto = 0";
        $consulta = $this->db->query($sentencia);
        $tickets = [];
        $chatPrivadoReportes = [];
        while ($fila = $consulta->fetch_assoc()) {
            $clave = "id" . $fila['id'];
            $chatPrivadoReportes[$clave] = $fila;
        }
        $tickets['chatPrivado'] = $chatPrivadoReportes;
        return $tickets;
    }
    function getTicketsUsuario()
    {
        $sentencia = "SELECT * FROM reporteusuario WHERE resuelto = 0";
        $consulta = $this->db->query($sentencia);
        $tickets = [];
        $usuarioReportes = [];
        while ($fila = $consulta->fetch_assoc()) {
            $clave = "id" . $fila['id'];
            $usuarioReportes[$clave] = $fila;
        }
        $tickets['usuario'] = $usuarioReportes;
        return $tickets;
    }
    function quitarTicketAnuncio($id)
    {
        $sentencia = "UPDATE reportepartidaanuncio SET resuelto = 1 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
    function quitarTicketChatForo($id)
    {
        $sentencia = "UPDATE reporteforomensaje SET resuelto = 1 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
    function quitarTicketChatPrivado($id)
    {
        $sentencia = "UPDATE reportechatprivado SET resuelto = 1 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
    function quitarTicketUsuario($id)
    {
        $sentencia = "UPDATE reporteusuario SET resuelto = 1 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
}
?>