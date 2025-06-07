<?php
class usuario
{
    private $db;
    public function __construct($barritas)
    {
        // require_once ($barritas.'cred.php');
        // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
        $this->db = new mysqli("localhost", "root", "", "frikeria");
    }

    //Comprobar credenciales del usuario para ver si existe y los datos son correctos
    public function compCrede(String $nom, String $contra)
    {
        $sentencia = "SELECT COUNT(*) FROM usuario WHERE nombre=? AND contra=? AND estado = 1";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ss", $nom, $contra);
        $consulta->bind_result($count);

        $consulta->execute();
        $consulta->fetch();

        $existe = false;

        if ($count == 1) $existe = true;

        $consulta->close();

        return $existe;
    }

    //Comprobar si existe el nombre de usuario
    public function compExistencia(String $nom)
    {
        $sentencia = "SELECT COUNT(*) FROM usuario WHERE nombre=? AND estado = 1";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("s", $nom);
        $consulta->bind_result($count);

        $consulta->execute();
        $consulta->fetch();

        $noExiste = ["estado" => true];

        if ($count > 0) $noExiste = ["estado" => false, "msj" => "Nombre de usuario ya existe."];

        $consulta->close();

        return $noExiste;
    }

    //Comprobar si existe el mail en otro usuario
    public function compExistenciaMail(String $nom)
    {
        $sentencia = "SELECT COUNT(*) FROM usuario WHERE mail=? AND estado = 1";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("s", $nom);
        $consulta->bind_result($count);

        $consulta->execute();
        $consulta->fetch();

        $noExiste = ["estado" => true];

        if ($count > 0) $noExiste = ["estado" => false, "msj" => "Correo electronico esta en uso"];;

        $consulta->close();

        return $noExiste;
    }

    //Comprobar si el usuario es admin
    public function compAdmin(String $nom)
    {
        $sentencia = "SELECT COUNT(*) FROM usuario WHERE role=1 AND nombre=?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("s", $nom);
        $consulta->bind_result($count);

        $consulta->execute();
        $consulta->fetch();

        $existe = false;

        if ($count == 1) $existe = true;

        $consulta->close();

        return $existe;
    }

    //Devuelve los datos para la lista de usuarios
    public function listUser()
    {
        $sentencia = "SELECT nombre, contra FROM usuario WHERE role=0";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_result($nom, $contra);

        $consulta->execute();

        $arrResult = array();
        while ($consulta->fetch()) {
            $remp = preg_replace("/./", "*", $contra);
            array_push($arrResult, array($nom, $remp));
        }

        $consulta->close();

        return $arrResult;
    }

    //Busca usuarios con nombres que contengan la string introducida
    public function busquedaUser(String $parte)
    {
        $sentencia = "SELECT nombre, contra FROM usuario WHERE role=0 AND LOWER(nombre) LIKE ?";
        $consulta = $this->db->prepare($sentencia);
        $busqueda = strtolower("%" . $parte . "%");
        $consulta->bind_param("s", $busqueda);
        $consulta->bind_result($nom, $contra);

        $consulta->execute();

        $arrResult = array();
        while ($consulta->fetch()) {
            $remp = preg_replace("/./", "*", $contra);
            array_push($arrResult, array($nom, $remp));
        }

        $consulta->close();

        return $arrResult;
    }

    //Modifica los datos de un usuario
    public function modUser(String $nom, String $contra, String $mail, String $foto)
    {
        session_start();
        $usuario = $_SESSION['user'];
        $sentencia = "UPDATE usuario SET contra=?, nombre=?, mail=?, foto = CASE WHEN ? IS NOT NULL THEN ? ELSE foto END 
        WHERE nombre=?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ssssss", $contra, $nom, $mail, $foto, $foto, $usuario);
        $consulta->execute();
        $filasAfectadas = $consulta->affected_rows;
        $consulta->close();

        if ($filasAfectadas > 0) {
            unset($_SESSION['user']);
            $_SESSION['user'] = $nom;
        }
    }
    //Introducir los datos de un Usuario

    public function insertUser(String $nom, String $contra, String $mail)
    {
        $sentencia = "INSERT INTO usuario (nombre, contra, mail) VALUES (?,?,?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("sss", $nom, $contra, $mail);
        $consulta->execute();
        $consulta->close();
    }
    //Conseguir el ID de un usuario, comunmente el usuario que se loguea
    public function getId(String $nom)
    {
        $sentencia = "SELECT id FROM usuario WHERE nombre=?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("s", $nom);
        $consulta->bind_result($id);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        return $id;
    }

    //Conseguir todos los datos del usuario
    public function getDatos(String $nom)
    {
        $sentencia = "SELECT contra, mail, foto FROM usuario WHERE nombre=?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("s", $nom);
        $consulta->bind_result($contra, $mail, $foto);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        return array(
            "nom" => $nom,
            'contra' => $contra,
            'mail' => $mail,
            'foto' => $foto
        );
    }
    //Conseguir el nombre y la foto de un usuario a partir de su ID
    public function getDatosForoUsuario(int $id)
    {
        $sentencia = "SELECT nombre, foto FROM usuario WHERE id=?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $consulta->bind_result($nom, $foto);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        return array(
            "nom" => $nom,
            'foto' => $foto
        );
    }
    //Conseguir el nombre de un usuario a partir de su ID
    public function getNombreUsuario(int $id)
    {
        $sentencia = "SELECT nombre FROM usuario WHERE id=?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $consulta->bind_result($nom);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        return $nom;
    }

    //Conseguir el role de un usuario a partir de su nombre
    public function getRole(String $nom)
    {
        $sentencia = "SELECT role FROM usuario WHERE nombre=?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("s", $nom);
        $consulta->bind_result($role);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        return $role;
    }

    //Eliminar un usuario y todas sus partidas
    function quitarUsuario($id)
    {
        $res = ["estado" => true, "mensaje" => "Todos los datos del usuario, sus partidas y elementos relacionado a sus tickets han sido eliminados."];
        $sentencias =
            [
                ["input"=>"UPDATE usuario SET estado = 0 WHERE id = ?", "mensaje"=>"Error al eliminar el usuario."],
                ["input"=>"UPDATE mensajeschatprivados mcp JOIN reportechatprivado rcp ON mcp.id = rcp.idMensaje SET mcp.estado = 0, rcp.resuelto = 1 WHERE mcp.idUsuario = ?;", "mensaje"=>"Error al eliminar los mensajes privados del usuario y sus tickets."],
                ["input"=>"UPDATE foromensaje fm JOIN reporteforomensaje rfm ON fm.id = rfm.idMensaje SET fm.estado = 0, rfm.resuelto = 1 WHERE fm.idUser = ?;", "mensaje"=>"Error al eliminar los mensajes del foro relacionado con el usuario y sus tickets."],
                ["input"=>"UPDATE reporteusuario SET resuelto = 1 WHERE idUsuario = ?;", "mensaje"=>"Error al eliminar los tickets del usuario."],
                ["input"=>"UPDATE partidas p JOIN reportepartidaanuncio rpa ON p.id = rpa.idPartida SET p.estado = 0, rpa.resuelto = 1 WHERE p.idCreador = ?;", "mensaje"=>"Error al eliminar los anuncios de partidas del usuario y sus tickets."],
                ["input"=>"UPDATE partidas SET estado = 0 WHERE idCreador = ?", "mensaje"=>"Error al eliminar las partidas del usuario."]
            ];
        for ($i = 0; $i < count($sentencias) && $res["estado"]; $i++) {
            $sentencia = $sentencias[$i];
            $consulta = $this->db->prepare($sentencia["input"]);
            $consulta->bind_param("i", $id);
            $ejecutar = $consulta->execute();
            if (!$ejecutar) {
                $res = ["estado" => false, "mensaje" => $sentencia["mensaje"]];
            }
            $consulta->close();
        }
        return $res;
    }
}
