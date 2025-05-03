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
        session_start();
        $user = new usuario("../../../");
        $id_user = $user->getId($_SESSION["user"]);
        $sentencia = "INSERT INTO partidas (titulo, juego, numJugadores, fecha, descripcion, latitud, longitud, ciudad, idCreador, portada) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ssissddsss", $nombre, $juego, $numJugadores, $fechaInicio, $descripcion, $latitud, $longitud, $ciudad, $id_user, $portada_path);
        $consulta->execute();
        $consulta->close();
    }
    //Buscar partida
    public function buscarPartidas($latitud, $longitud)
    {
        require_once("../classes/usuario.php");
        $sentencia = "
        SELECT titulo, juego, numJugadores, fecha, descripcion, latitud, longitud, ciudad, portada
        FROM partidas
        ORDER BY (6371 * ACOS(
            COS(RADIANS(?)) * COS(RADIANS(latitud)) *
            COS(RADIANS(longitud) - RADIANS(?)) +
            SIN(RADIANS(?)) * SIN(RADIANS(latitud))
        )) ASC";
        $consulta = $this->db->prepare($sentencia);
        $consulta->bind_param("ddd", $latitud, $longitud, $latitud);
        $consulta->bind_result($titulo, $juego, $numJugadores, $fecha, $descripcion, $lat, $lng, $ciudad, $portada);
        $consulta->execute();
        $res = [];
        while ($consulta->fetch()) {
            $res[] = [
                'titulo' => $titulo,
                'juego' => $juego,
                'numJugadores' => $numJugadores,
                'fecha' => $fecha,
                'descripcion' => $descripcion,
                'latitud' => $lat,
                'longitud' => $lng,
                'ciudad' => $ciudad,
                'portada' => $portada
            ];
        }
        $consulta->close();
        return $res;
    }
}
