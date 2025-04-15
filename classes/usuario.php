<?php
    class usuario{
        private $db;
        public function __construct($barritas){
            // require_once ($barritas.'cred.php');
            // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
            $this->db = new mysqli("localhost","root", "", "frikeria");
        }

        //Comprobar credenciales del usuario para ver si existe y los datos son correctos
        public function compCrede(String $nom, String $contra){
            $sentencia = "SELECT COUNT(*) FROM usuario WHERE nombre=? AND contra=?";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("ss", $nom, $contra);
            $consulta->bind_result($count);

            $consulta->execute();
            $consulta->fetch();

            $existe = false;

            if($count == 1) $existe=true;

            $consulta->close();
            
            return $existe;
        }

        //Comprobar si el usuario es admin
        public function compAdmin(String $nom){
            $sentencia = "SELECT COUNT(*) FROM usuario WHERE role=1 AND nombre=?";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("s", $nom);
            $consulta->bind_result($count);

            $consulta->execute();
            $consulta->fetch();

            $existe = false;

            if($count == 1) $existe=true;

            $consulta->close();
            
            return $existe;
        }

        //Devuelve los datos para la lista de usuarios
        public function listUser(){
            $sentencia = "SELECT nombre, contra FROM usuario WHERE role=0";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_result($nom,$contra);
        
            $consulta->execute();
        
            $arrResult = array();
            while($consulta->fetch()){
                $remp=preg_replace("/./","*",$contra);
                array_push($arrResult,array($nom,$remp));
            }
        
            $consulta->close();
        
            return $arrResult;
        }

        //Busca usuarios con nombres que contengan la string introducida
        public function busquedaUser(String $parte){
            $sentencia = "SELECT nombre, contra FROM usuario WHERE role=0 AND LOWER(nombre) LIKE ?";
            $consulta = $this->db->prepare($sentencia);
            $busqueda = strtolower("%".$parte."%");
            $consulta->bind_param("s", $busqueda);
            $consulta->bind_result($nom,$contra);
                
            $consulta->execute();
                
            $arrResult = array();
            while($consulta->fetch()){
                $remp=preg_replace("/./","*",$contra);
                array_push($arrResult,array($nom,$remp));
            }
                
            $consulta->close();
                
            return $arrResult;
        }
        
        //Modifica los datos de un usuario
        public function modUser(String $nom, String $contra){
            $id = $this->getId($nom);
            $sentencia = "UPDATE usuario SET contra=?, nombre=? WHERE id=?";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("sss", $contra, $nom, $id);
            $consulta->execute();
            $consulta->close();
        }
        //Introducir los datos de un Usuario

        public function insertUser(String $nom, String $contra, String $mail){
            $sentencia = "INSERT INTO usuario (nombre, contra, mail) VALUES (?,?,?)";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("sss", $nom, $contra, $mail);
            $consulta->execute();
            $consulta->close();
        }
        //Conseguir el ID de un usuario, comunmente el usuario que se loguea
        public function getId(String $nom){
            $sentencia = "SELECT id FROM usuario WHERE nombre=?";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("s", $nom);
            $consulta->bind_result($id);
            $consulta->execute();
            $consulta->fetch();
            $consulta->close();
            return $id;
        }

        public function getUser(String $nom){
            $sentencia = "SELECT nombre, foto FROM usuario WHERE nombre=?";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("s", $nom);
            $consulta->bind_result($nombre,$foto);
            $consulta->execute();
            $consulta->fetch();
            $consulta->close();
            $result=array($nombre,$foto);
            return $result;
        }
    }
?>