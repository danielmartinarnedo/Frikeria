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
    //Crear un mensaje en un chat privado
    public function crearMensajePrivado($texto, $id_chat)
    {
        require_once("../classes/usuario.php");
        session_start();
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $sentencia = "INSERT INTO mensajeschatprivados (idUsuario, idChat, texto) VALUES (?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("iis", $id_user, $id_chat, $texto);
        $consulta->execute();
        $consulta->close();
    }
    //Busca todos los mensajes de un chat privado
    public function buscarMensajesPrivados($id_chat)
    {
        $sentencia = "SELECT id, idUsuario, texto FROM mensajeschatprivados WHERE idChat = ? AND estado = 1 ORDER BY fecha ASC";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id_chat);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $consulta->close();
        $mensajes = array();
        session_start();
        $nombre_usuario = $_SESSION["user"];
        require_once("../classes/usuario.php");
        require_once("../classes/bloqueado.php");
        $user = new usuario("../../../");
        $bloc = new bloqueado("../../../");
        while ($datos = $resultado->fetch_assoc()) {
            $usuario = $user->getDatosForoUsuario($datos["idUsuario"]);
            $texto = ($datos["texto"]);
            $soyYo = false;
            $bloqueado = false;
            $estoyBloqueado = false;
            if ($nombre_usuario == $usuario["nom"]) {
                $soyYo = true;
            } else {
                $bloqueado = $bloc->buscarBloqueado($usuario["nom"]);
                $estoyBloqueado = $bloc->estoyBloqueado($usuario["nom"]);
            }
            array_push($mensajes, array(
                "usuarioId" => $datos["idUsuario"],
                "usuarioNom" => $usuario["nom"],
                "usuarioImg" => $usuario["foto"],
                "texto" => $texto,
                "estado" => $soyYo,
                "bloqueo" => $bloqueado,
                "estoyBloqueado" => $estoyBloqueado,
                "idMensaje" => $datos["id"]
            ));
        }
        return $mensajes;
    }
    // Buscar el ultimo mensaje de un chat privado de un usuario
    public function buscarUltimoMensaje($idChat)
    {
        $sentencia = "SELECT texto, idUsuario FROM mensajeschatprivados WHERE idChat = ? ORDER BY fecha DESC LIMIT 1";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $idChat);
        $consulta->bind_result($texto, $idUsuario);
        $consulta->execute();
        if ($consulta->fetch()) {
            require_once("../classes/usuario.php");
            $user = new usuario("../../../");
            $nombreUsuario = $user->getNombreUsuario($idUsuario);
            return array("texto" => $texto, "nombreUsu" => $nombreUsuario);
        } else {
            return null;
        }
        $consulta->close();
    }
    // Quitar un mensaje del chat privado
    function quitarMensaje($idMensaje)
    {
        $sentencia = "UPDATE mensajeschatprivados SET estado = 0 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $idMensaje);
        $res=$consulta->execute();
        $consulta->close();
        return $res>0;
    }
    // Buscar los mensajes eliminados de un chat privado relacionados con un Usuario
    function cojerIdMensajesEliminadosPrivados($idChat, $idUsuario) {
        $sentencia = "SELECT id FROM mensajeschatprivados WHERE idChat = ? AND idUsuario = ? AND estado = 0";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ii", $idChat, $idUsuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $consulta->close();
        $mensajes = array();
        while ($datos = $resultado->fetch_assoc()) {
            array_push($mensajes, $datos["id"]);
        }
        file_put_contents('test.txt', print_r($mensajes, true));
        return $mensajes;
    }
}
?>