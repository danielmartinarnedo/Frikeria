<?php
class chatPrivado
{
    private $db;
    public function __construct($barritas)
    {
        // require_once ($barritas.'cred.php');
        // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
        $this->db = new mysqli("localhost", "root", "", "frikeria");
    }
    //Crear el chat privado
    public function crearChat($id_usuario)
    {
        require_once("../classes/usuario.php");
        session_start();
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $sentencia = "INSERT INTO chatprivado (idUsuario1, idUsuario2) VALUES (?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ii", $id_user, $id_usuario);
        $consulta->execute();
        $idInsertado = $this->db->insert_id;
        $consulta->close();
        return $idInsertado;
    }
    //Mira si existe el chat privado, lo manda a crearse si no existe y devuelve la id del chat
    public function checkExistenciaChat($nomUsuario)
    {
        require_once("../classes/usuario.php");
        session_start();
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $id_usuario = $user->getId($nomUsuario);
        $sentencia = "SELECT id FROM chatprivado WHERE (idUsuario1 = ? AND idUsuario2 = ?) OR (idUsuario1 = ? AND idUsuario2 = ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("iiii", $id_user, $id_usuario, $id_usuario, $id_user);
        $consulta->bind_result($id);
        $consulta->execute();
        $encontrado = $consulta->fetch();
        $consulta->close();
        if (!$encontrado) {
            $id = $this->crearChat($id_usuario);
        }
        return $id;
    }
    
}
?>