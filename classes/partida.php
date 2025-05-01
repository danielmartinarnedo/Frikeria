<?php
    class partida{
        private $db;
        public function __construct($barritas){
            // require_once ($barritas.'cred.php');
            // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
            $this->db = new mysqli("localhost","root", "", "frikeria");
        }
        //Crear una partida
        public function crearPartida($nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $portada_path){
            require_once("../classes/usuario.php");
            session_start();
            $user = new usuario("../../../");
            $id_user = $user->getId($_SESSION["user"]);
            $sentencia = "INSERT INTO partidas (titulo, juego, numJugadores, fecha, descripcion, latitud, longitud, ciudad, idCreador, portada) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("ssissddsss", $nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $id_user, $portada_path);            
            $consulta->execute();
            $consulta->close();
        }
    }
?>
    
            