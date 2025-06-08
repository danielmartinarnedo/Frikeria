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
    //Crear un mensaje en un foro
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
    // Carga todos los mensajes de un foro
    public function buscarMensajes($id_anuncio)
    {
        $sentencia = "SELECT idUser, texto, id FROM foromensaje WHERE idAnuncio = ? AND estado = 1 ORDER BY fecha ASC";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id_anuncio);
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
            $usuario = $user->getDatosForoUsuario($datos["idUser"]);
            $texto = ($datos["texto"]);
            $idMensaje = $datos["id"];
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
                "usuarioId" => $datos["idUser"],
                "usuarioNom" => $usuario["nom"],
                "usuarioImg" => $usuario["foto"],
                "texto" => $texto,
                "estado" => $soyYo,
                "bloqueo" => $bloqueado,
                "estoyBloqueado" => $estoyBloqueado,
                "idMensaje" => $idMensaje
            ));
        }
        return $mensajes;
    }
    //Hace un ban a un mensaje
    function quitarMensaje($idMensaje)
    {
        $sentencia = "UPDATE foromensaje SET estado = 0 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $idMensaje);
        $res=$consulta->execute();
        $consulta->close();
        return $res>0;
    }
    //Carga todos los mensajes eliminados de un foro
    function cojerIdMensajesEliminadosChatForo($idChat, $idUsuario) {
        $sentencia = "SELECT id FROM foromensaje WHERE idAnuncio = ? AND idUser = ? AND estado = 0";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ii", $idChat, $idUsuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $consulta->close();
        $mensajes = array();
        while ($datos = $resultado->fetch_assoc()) {
            array_push($mensajes, $datos["id"]);
        }
        return $mensajes;
    }
}
