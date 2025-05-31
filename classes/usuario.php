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
        $sentencia = "SELECT COUNT(*) FROM usuario WHERE nombre=? AND contra=?";
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
        $consulta->close();
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
}
