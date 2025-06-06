<?php
class partida
{
    private $db;
    public function __construct($barritas)
    {
        // require_once ($barritas.'cred.php');
        // $this->db = new mysqli("localhost",USU_CONN, PSW_CONN, "frikeria");
        $this->db = new mysqli("localhost", "root", "", "frikeria");
    }
    //Crear una partida
    public function crearPartida($nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $portada_path)
    {
        require_once("../classes/usuario.php");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $sentencia = "INSERT INTO partidas (titulo, juego, numJugadores, fecha, descripcion, latitud, longitud, ciudad, idCreador, portada) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ssissddsss", $nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $id_user, $portada_path);
        $consulta->execute();
        $consulta->close();
    }
    // Actualizar una partida
    public function modPartida($idPartida, $nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $portada_path)
    {
        require_once("../classes/usuario.php");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        if ($portada_path) {
            $sentencia = "UPDATE partidas SET titulo=?, juego=?, numJugadores=?, fecha=?, descripcion=?, latitud=?, longitud=?, ciudad=?, portada=? WHERE id=?";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("ssissddssi", $nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $portada_path, $idPartida);
        } else {
            $sentencia = "UPDATE partidas SET titulo=?, juego=?, numJugadores=?, fecha=?, descripcion=?, latitud=?, longitud=?, ciudad=? WHERE id=?";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("ssissddsi", $nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $idPartida);
        }
        $consulta->execute();
        $consulta->close();
    }
    //Buscar partida
    public function buscarPartidas($latitud, $longitud)
    {
        require_once("../classes/usuario.php");
        $sentencia = "
        SELECT titulo, juego, numJugadores, fecha, descripcion, latitud, longitud, ciudad, portada, id, idCreador
        FROM partidas WHERE fecha >= CURDATE() AND estado = 1
        ORDER BY (6371 * ACOS(
            COS(RADIANS(?)) * COS(RADIANS(latitud)) *
            COS(RADIANS(longitud) - RADIANS(?)) +
            SIN(RADIANS(?)) * SIN(RADIANS(latitud))
        )) ASC";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ddd", $latitud, $longitud, $latitud);
        $consulta->bind_result($titulo, $juego, $numJugadores, $fecha, $descripcion, $lat, $lng, $ciudad, $portada, $id, $idCreador);
        $consulta->execute();
        $res = [];
        require_once("../classes/usuario.php");
        $user = new usuario("../../../");
        while ($consulta->fetch()) {
            $nombreCreador = $user->getNombreUsuario($idCreador);
            $res[] = [
                'titulo' => $titulo,
                'juego' => $juego,
                'numJugadores' => $numJugadores,
                'fecha' => $fecha,
                'descripcion' => $descripcion,
                'latitud' => $lat,
                'longitud' => $lng,
                'ciudad' => $ciudad,
                'portada' => $portada,
                'id' => $id,
                'nombreCreador' => $nombreCreador
            ];
        }
        $consulta->close();
        return $res;
    }
    //Buscar las partidas que ha creado el usuario
    public function buscarPartidasPropias()
    {
        require_once("../classes/usuario.php");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $sentencia = "SELECT titulo, juego, numJugadores, fecha, descripcion, latitud, longitud, ciudad, portada, id FROM partidas WHERE idCreador = ? AND estado = 1";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id_user);
        $consulta->bind_result($titulo, $juego, $numJugadores, $fecha, $descripcion, $latitud, $longitud, $ciudad, $portada, $id);
        $consulta->execute();
        $res = [];
        while ($consulta->fetch()) {
            $res[] = [
                'titulo' => $titulo,
                'juego' => $juego,
                'numJugadores' => $numJugadores,
                'fecha' => $fecha,
                'descripcion' => $descripcion,
                'latitud' => $latitud,
                'longitud' => $longitud,
                'ciudad' => $ciudad,
                'portada' => $portada,
                'id' => $id
            ];
        }
        $consulta->close();
        return $res;
    }
    //Funcion para conseguir toda la informacion de una partida
    public function getPartida($id)
    {
        $sentencia = "SELECT titulo, juego, numJugadores, fecha, descripcion, ciudad, portada, idCreador FROM partidas WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $consulta->bind_result($titulo, $juego, $numJugadores, $fecha, $descripcion, $ciudad, $portada, $idCreador);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        require_once("../classes/usuario.php");
        $user = new usuario("../../../");
        $nombreCreador = $user->getNombreUsuario($idCreador);
        return array(
            'titulo' => $titulo,
            'juego' => $juego,
            'numJugadores' => $numJugadores,
            'fecha' => $fecha,
            'descripcion' => $descripcion,
            'ciudad' => $ciudad,
            'portada' => $portada,
            'nombreCreador' => $nombreCreador,
            'idCreador' => $idCreador
        );
    }
    //Funcion para quitar una partida
    function quitarPartida($id)
    {
        $sentencia = "UPDATE partidas SET estado = 0 WHERE id = ?";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("i", $id);
        $consulta->execute();
        $est = $consulta->affected_rows;
        $consulta->close();
        if ($est == 0) {
            $sentencia = "SELECT p.idCreador FROM partidas p, usuario u WHERE p.id = ? AND u.estado = 0 AND p.idCreador = u.id";
            $consulta = $this->db->prepare($sentencia);
            $consulta->bind_param("i", $id);
            $consulta->execute();
            $est = $consulta->affected_rows;
            $consulta->close();
        }
        return $est > 0;
    }
}
