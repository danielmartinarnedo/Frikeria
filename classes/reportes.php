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
    // CREAR REPORTES de PARTIDAS
    function crearReportePartida($id, $descripcion)
    {
         $sentencia = "INSERT INTO reportepartidaanuncio (idPartida, descripcion) VALUES (?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("is", $id, $descripcion);
        $resultado = $consulta->execute();
        $consulta->close();
    }
    // CREAR REPORTES de USUARIOS
    function crearReporteUsuario($id, $descripcion)
    {
         $sentencia = "INSERT INTO reporteusuario (idUsuario, descripcion) VALUES (?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("is", $id, $descripcion);
        $resultado = $consulta->execute();
        $consulta->close();
    }
    // CREAR REPORTES de FOROS
    function crearReporteForo($idChat, $idMensaje, $descripcion)
    {
         $sentencia = "INSERT INTO reporteforomensaje (idChat, idMensaje, descripcion) VALUES (?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("iis", $idChat, $idMensaje, $descripcion);
        $resultado = $consulta->execute();
        $consulta->close();
    }
    // CREAR REPORTES de mensajes CHAT PRIVADO
    function crearReporteChatPrivado($idChat, $idMensaje, $descripcion)
    {
         $sentencia = "INSERT INTO reportechatprivado (idChat, idMensaje, descripcion) VALUES (?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("iis", $idChat, $idMensaje, $descripcion);
        $resultado = $consulta->execute();
        $consulta->close();
    }
    // OBTENER TICKETS de Reportes
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
    // OBTENER TICKETS de Reportes de Mensajes del Foro
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
    // OBTENER TICKETS de Reportes de Mensajes del Chat Privado
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
    // OBTENER TICKETS de Reportes de USUARIOS
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
    // QUITAR TICKET de Reportes de Anuncio
    function quitarTicketAnuncio($id)
    {
        $sentencia = "UPDATE reportepartidaanuncio SET resuelto = 1 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
    // QUITAR TICKET de Reportes de Mensajes del Foro
    function quitarTicketChatForo($id)
    {
        $sentencia = "UPDATE reporteforomensaje SET resuelto = 1 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
    // QUITAR TICKET de Reportes de Mensajes del Chat Privado
    function quitarTicketChatPrivado($id)
    {
        $sentencia = "UPDATE reportechatprivado SET resuelto = 1 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
    // QUITAR TICKET de Reportes de USUARIOS
    function quitarTicketUsuario($id)
    {
        $sentencia = "UPDATE reporteusuario SET resuelto = 1 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
    // QUITAR TODOS LOS TICKETS de Reportes de Anuncio
    function quitarTodosTicketPartida($id)
    {
        $sentencia = "UPDATE reportepartidaanuncio SET resuelto = 1 WHERE idPartida = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $resultado = $consulta->execute();
        $consulta->close();
        return $resultado;
    }
    // QUITAR TODOS LOS TICKETS de Reportes de Mensajes del Foro
    function quitarTodosTicketForoMensaje($id)
    {
        $sentencia = "UPDATE reporteforomensaje SET resuelto = 1 WHERE idMensaje = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $consulta->execute();
        $consulta->close();
    }
    // QUITAR TODOS LOS TICKETS de Reportes de Mensajes del Chat Privado
    function quitarTodosTicketChatPrivado($id)
    {
        $sentencia = "UPDATE reportechatprivado SET resuelto = 1 WHERE idMensaje = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $consulta->execute();
        $consulta->close();
    }
}
?>