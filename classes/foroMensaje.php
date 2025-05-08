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
        $sentencia = "SELECT idUser, texto FROM foromensaje WHERE idAnuncio = ? AND estado = 1 ORDER BY fecha ASC";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id_anuncio);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $consulta->close();
        $mensajes = array();
        while ($datos = $resultado->fetch_assoc()) {
            require_once("../classes/usuario.php");
            $user = new usuario("../../../");
            $usuario = $user->getDatosForoUsuario($datos["idUser"]);
            $texto = htmlspecialchars($datos["texto"]);
            array_push($mensajes, array(
                "usuarioNom" => $usuario["nom"],
                "usuarioImg" => $usuario["foto"],
                "texto" => $texto
            ));
        }
        return $mensajes;
    }
}
