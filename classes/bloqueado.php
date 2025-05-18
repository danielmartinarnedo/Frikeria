<?php
class bloqueado
{
    private $db;
    public function __construct($barritas)
    {
        // require_once ($barritas.'cred.php');
        // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
        $this->db = new mysqli("localhost", "root", "", "frikeria");
    }
    //Funcion para bloquear un usuario
    public function crearBloqueo($nombreBloqueado)
    {
        require_once("../classes/usuario.php");
        session_start();
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $id_bloqueado = $user->getId($nombreBloqueado);
        $sentencia = "INSERT INTO bloqueados (idUsuario, idBloqueado) VALUES (?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ii", $id_user, $id_bloqueado);
        $consulta->execute();
        $consulta->close();
    }
    //Chequear si un usuario esta bloqueado
    public function buscarBloqueado($nombre_user)
    {
        require_once("../classes/usuario.php");
        $user = new usuario("../../../");
        $idUser = $user->getId($nombre_user);
        $Idyo = $user->getId($_SESSION["user"]);
        $sentencia = "SELECT CAST(COUNT(1) AS UNSIGNED) AS bloqueado FROM bloqueados WHERE idBloqueado = ? AND idUsuario = ? AND estado=1";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ii", $idUser, $Idyo);
        $consulta->execute();
        $consulta->bind_result($bloqueoEstado);
        $consulta->fetch();
        $consulta->close();
        return ($bloqueoEstado>0);
    }
    //Chequear si un usuario te esta bloqueando
    public function estoyBloqueado($nombre_user)
    {
        require_once("../classes/usuario.php");
        $user = new usuario("../../../");
        $idUser = $user->getId($nombre_user);
        $Idyo = $user->getId($_SESSION["user"]);
        $sentencia = "SELECT CAST(COUNT(1) AS UNSIGNED) AS bloqueado FROM bloqueados WHERE idBloqueado = ? AND idUsuario = ? AND estado=1";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ii", $Idyo, $idUser);
        $consulta->execute();
        $consulta->bind_result($bloqueoEstado);
        $consulta->fetch();
        $consulta->close();
        return ($bloqueoEstado>0);
    }
    public function desbloquear($nombreBloqueado)
    {
        require_once("../classes/usuario.php");
        session_start();
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $id_bloqueado = $user->getId($nombreBloqueado);
        $sentencia = "UPDATE bloqueados SET estado=0 WHERE idBloqueado = ? AND idUsuario = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ii", $id_bloqueado, $id_user);
        $consulta->execute();
        $consulta->close();
    }
}
