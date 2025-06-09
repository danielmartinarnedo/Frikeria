-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 01:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frikeria`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_estados` ()   BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE tbl_name VARCHAR(255);
  DECLARE cur CURSOR FOR
    SELECT TABLE_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE COLUMN_NAME = 'estado'
      AND TABLE_NAME != 'bloqueado'
      AND TABLE_SCHEMA = DATABASE();
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  OPEN cur;

  read_loop: LOOP
    FETCH cur INTO tbl_name;
    IF done THEN
      LEAVE read_loop;
    END IF;

    SET @sql = CONCAT('UPDATE `', tbl_name, '` SET `estado` = 1');
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
  END LOOP;

  CLOSE cur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_resueltos` ()   BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE tbl_name VARCHAR(255);
  DECLARE cur CURSOR FOR
    SELECT TABLE_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE COLUMN_NAME = 'resuelto'
      AND TABLE_NAME != 'bloqueado'
      AND TABLE_SCHEMA = DATABASE();
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  OPEN cur;

  read_loop: LOOP
    FETCH cur INTO tbl_name;
    IF done THEN
      LEAVE read_loop;
    END IF;

    SET @sql = CONCAT('UPDATE `', tbl_name, '` SET `resuelto` = 0');
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
  END LOOP;

  CLOSE cur;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bloqueados`
--

CREATE TABLE `bloqueados` (
  `id` int(11) NOT NULL,
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `idBloqueado` bigint(20) UNSIGNED NOT NULL COMMENT 'id del usuario bloqueado',
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `bloqueados`
--

INSERT INTO `bloqueados` (`id`, `idUsuario`, `idBloqueado`, `estado`) VALUES
(1, 2, 1, 1),
(2, 2, 1, 1),
(3, 2, 1, 1),
(4, 2, 1, 1),
(5, 2, 1, 1),
(6, 2, 1, 1),
(7, 2, 1, 1),
(8, 2, 1, 1),
(9, 2, 1, 1),
(10, 2, 1, 1),
(11, 2, 1, 1),
(12, 2, 1, 1),
(13, 9, 2, 0),
(14, 9, 2, 0),
(15, 9, 2, 0),
(16, 9, 2, 0),
(17, 9, 2, 0),
(18, 9, 2, 0),
(19, 9, 2, 0),
(20, 9, 2, 0),
(21, 9, 2, 0),
(22, 9, 2, 0),
(23, 9, 2, 0),
(24, 9, 2, 0),
(25, 9, 2, 0),
(26, 9, 2, 0),
(27, 9, 2, 0),
(28, 2, 9, 0),
(29, 9, 2, 0),
(30, 9, 2, 0),
(31, 9, 2, 0),
(32, 9, 2, 0),
(33, 2, 9, 0),
(34, 2, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chatprivado`
--

CREATE TABLE `chatprivado` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUsuario1` bigint(20) UNSIGNED NOT NULL,
  `idUsuario2` bigint(20) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `chatprivado`
--

INSERT INTO `chatprivado` (`id`, `idUsuario1`, `idUsuario2`, `estado`) VALUES
(3, 2, 1, 1),
(5, 2, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `foromensaje`
--

CREATE TABLE `foromensaje` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `idAnuncio` bigint(20) UNSIGNED NOT NULL,
  `texto` varchar(10000) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `foromensaje`
--

INSERT INTO `foromensaje` (`id`, `idUser`, `idAnuncio`, `texto`, `fecha`, `estado`) VALUES
(1, 1, 4, 'Esto es una prueba', '2025-05-04 20:00:00', 1),
(2, 1, 4, 'Esto es otra prueba', '2025-05-04 21:34:12', 1),
(3, 1, 4, 'Holiiii', '2025-05-08 15:58:40', 1),
(4, 1, 4, 'Otra prueba', '2025-05-08 16:00:02', 1),
(5, 2, 4, 'Usasda', '2025-05-18 14:41:20', 1),
(6, 9, 11, '<p>Lleva la tarara <b>un </b><i>vestido</i></p>', '2025-06-03 17:55:23', 1),
(7, 2, 11, '<ol><li>llsllasdasddasdasd<u>asdasdasdasdasdasdsadas</u></li></ol>', '2025-06-03 18:04:19', 1),
(8, 9, 8, '<p>Hola que tal</p>', '2025-06-06 21:11:50', 1),
(9, 9, 8, '<p>Como estas?</p><p><br></p>', '2025-06-06 21:11:59', 1),
(10, 9, 8, '<p>Bien y tu?</p>', '2025-06-06 21:12:06', 1),
(11, 2, 8, '<p>holi</p><p><br></p>', '2025-06-06 21:14:33', 1),
(12, 9, 15, '<p>Aqui teneis un tutorial de como jugar Dragones Y Mazmorras. Quien se apunta?</p><p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/DFpG47HfDeo\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2025-06-09 00:21:42', 1),
(13, 9, 16, '<p>Hey, muy buenas a todos, guapisimos dejad aqui vuestra caracter con el que vais a jugrar.</p>', '2025-06-09 13:18:50', 1),
(14, 9, 16, 'Y recordad buen comportamiento en el chat', '2025-06-09 13:28:30', 1),
(15, 2, 16, '<p>Mi personaje es <a href=\"https://pathbuilder2e.com/launch.html?build=1144441\" target=\"_blank\">Bart</a>, un luchador que se especializa en ataques con lanza.</p><p><br></p>', '2025-06-09 13:41:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mensajeschatprivados`
--

CREATE TABLE `mensajeschatprivados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idChat` bigint(20) UNSIGNED NOT NULL,
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `texto` mediumtext NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Bloqueado 1=No Bloqueado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mensajeschatprivados`
--

INSERT INTO `mensajeschatprivados` (`id`, `idChat`, `idUsuario`, `texto`, `fecha`, `leido`, `estado`) VALUES
(1, 3, 2, 'Hola', '2025-05-31 11:53:41', 0, 1),
(2, 3, 2, 'Esto puede ocurrir', '2025-05-31 12:14:11', 0, 1),
(3, 3, 1, 'La vida', '2025-05-31 14:27:30', 0, 1),
(4, 3, 1, 'lleva la tarara un vestido blanco lleno de cascabeles', '2025-05-31 14:53:35', 0, 1),
(5, 5, 2, '<p>Holiiii</p>', '2025-06-03 18:20:36', 0, 1),
(6, 5, 2, '<p><b>asdasd</b></p>', '2025-06-03 18:20:40', 0, 1),
(7, 5, 2, '<p><i>asd</i></p>', '2025-06-03 18:20:43', 0, 1),
(8, 5, 2, '<ol><li><u>asdasdasd</u></li></ol>', '2025-06-03 18:20:48', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `partidas`
--

CREATE TABLE `partidas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(500) NOT NULL,
  `juego` varchar(500) NOT NULL,
  `numJugadores` int(2) NOT NULL,
  `fecha` date NOT NULL,
  `portada` varchar(500) NOT NULL,
  `descripcion` varchar(10000) NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL,
  `ciudad` varchar(500) DEFAULT NULL,
  `idCreador` bigint(20) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `partidas`
--

INSERT INTO `partidas` (`id`, `titulo`, `juego`, `numJugadores`, `fecha`, `portada`, `descripcion`, `latitud`, `longitud`, `ciudad`, `idCreador`, `estado`) VALUES
(4, 'Prueba', 'ADPrueba', 4, '2025-05-08', '../images/portada_6813a59bccb213.00621182.jpg', 'adasdsssssdasdasdasdasdada\r\nasdasd\r\nasd\r\nasda\r\nsd\r\nad\r\na\r\na\r\nd\r\na\r\nda\r\nd\r\na\r\nda\r\nd\r\na\r\nda\r\nd\r\na\r\nda\r\nda', 36.7394816, -3.4870026828124945, 'Las Ventillas', 1, 1),
(5, 'Prueba', 'Prueba2', 4, '2025-05-30', '../images/portada_682f1133e7b6f0.92267324.jpg', 'asdasdasd', 37.174294811900765, -3.598307931392255, 'Granada', 2, 1),
(6, 'Prueba24567', 'Prueba24567', 4, '2025-06-03', '../images/portada_683b59ce0df5f1.73805200.jpg', 'Esto es una prueba', 37.03384986638156, -3.5825838716104452, 'Padul', 2, 1),
(7, 'Prueba123', 'Prueba24567', 4, '2025-06-05', '../images/Pathfinder2ogimage.jpg', 'Aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 36.7394816, -3.5913728, 'Salobreña', 2, 1),
(8, 'Prueba1235', 'Prueba22', 4, '2025-06-07', '../images/Pathfinder2ogimage.jpg', '<p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasdasdasd2345</p>', 37.16966568743458, -3.6012621046379034, 'Granada', 9, 1),
(11, 'Prueba24567', 'Prueba24567', 5, '2025-06-08', '../images/Pathfinder2ogimage.jpg', '<ul><li>j<b>kl</b><i>oi<u>868666666666666666666666666666666</u></i></li></ul>', 37.182796228137136, -3.5441317231729452, 'Granada', 9, 1),
(12, 'Preasd24', 'wee2', 4, '2025-06-09', '../images/Pathfinder2ogimage.jpg', '<p>Lleva la tarara un vestido blanco lleno de cascabeles.</p>', 37.173702101058346, -3.6002808705955247, 'Granada', 9, 1),
(13, 'Unnombre', 'HOla', 3, '2025-06-11', '../images/Pathfinder2ogimage.jpg', '<p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>', 36.7394816, -3.5913728, 'Salobreña', 9, 1),
(14, 'Name', 'Game', 4, '2025-06-09', '../images/Pathfinder2ogimage.jpg', '<p>AaAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA</p>', 36.7466088, -3.586411, 'Salobreña', 9, 1),
(15, 'Tutorial', 'Dragones Y Mazmorrars', 3, '2025-06-20', '../images/815XxpBjHpL._AC_UF1000,1000_QL80_.jpg', '<p>Esto es un tutorial de como jugar la primera versión de <b>DRAGONES Y MAZMORRAS.</b></p>', 36.746583, -3.5863371, 'Salobreña', 9, 1),
(16, 'Pathfinder Kingmaker', 'Pathfinder 2e', 3, '2025-06-14', '../images/Pathfinder2ogimage.jpg', '<p data-start=\"94\" data-end=\"418\">?️ <strong data-start=\"98\" data-end=\"144\">¡Se buscan valientes para forjar un reino!</strong> ⚔️<br data-start=\"147\" data-end=\"150\">\nEste <strong data-start=\"155\" data-end=\"177\">sábado a las 16:00</strong> comienza nuestra épica campaña de <strong data-start=\"212\" data-end=\"225\">Kingmaker</strong>. Aventura, exploración y decisiones que marcarán el destino de una nación te esperan.<br data-start=\"311\" data-end=\"314\" data-is-only-node=\"\">\nForma parte de un grupo de pioneros en tierras salvajes, construye tu legado... o muere en el intento.</p>\n<p data-start=\"420\" data-end=\"473\"><strong data-start=\"420\" data-end=\"473\">¡Plazas limitadas! ¿Te atreves a tomar la corona?</strong></p><p data-start=\"420\" data-end=\"473\"><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/MrP8-wuZSoU\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><strong data-start=\"420\" data-end=\"473\"><br></strong></p>', 36.7394816, -3.5913728, 'Salobreña', 9, 1),
(17, 'La Huella de los Dioses', 'Call of Cthulhu', 2, '2025-06-15', '../images/61vJOgQA8DL._AC_UF1000,1000_QL80_DpWeblab_.jpg', '<p data-start=\"146\" data-end=\"465\">?️ <strong data-start=\"150\" data-end=\"210\">El fin del mundo puede empezar con una pista olvidada...</strong> ?️<br data-start=\"214\" data-end=\"217\">\r\nEste <strong data-start=\"222\" data-end=\"245\">domingo a las 20:00</strong> nos sumergimos en los horrores de <strong data-start=\"280\" data-end=\"307\">La Huella de los Dioses</strong>, una campaña de <em data-start=\"324\" data-end=\"341\" data-is-only-node=\"\">Call of Cthulhu</em> donde el misterio, la locura y lo desconocido acechan en cada esquina.<br data-start=\"412\" data-end=\"415\">\r\n¿Podrás descubrir la verdad sin perder tu cordura?</p>\r\n<p data-start=\"467\" data-end=\"522\"><strong data-start=\"467\" data-end=\"522\">Prepara tu ficha, afila tu mente… y no mires atrás.</strong></p><p><br></p>', 36.98830105875798, -3.5676405535264477, 'Dúrcal', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reportechatprivado`
--

CREATE TABLE `reportechatprivado` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idChat` bigint(20) UNSIGNED NOT NULL,
  `idMensaje` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(5000) NOT NULL,
  `resuelto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `reportechatprivado`
--

INSERT INTO `reportechatprivado` (`id`, `idChat`, `idMensaje`, `descripcion`, `resuelto`) VALUES
(4, 5, 8, 'Holiiiiiiiiiii', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reporteforomensaje`
--

CREATE TABLE `reporteforomensaje` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idChat` bigint(20) UNSIGNED NOT NULL,
  `idMensaje` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(5000) NOT NULL,
  `resuelto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `reporteforomensaje`
--

INSERT INTO `reporteforomensaje` (`id`, `idChat`, `idMensaje`, `descripcion`, `resuelto`) VALUES
(1, 11, 7, 'asdasdasdasdas', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reportepartidaanuncio`
--

CREATE TABLE `reportepartidaanuncio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idPartida` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(5000) NOT NULL,
  `resuelto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `reportepartidaanuncio`
--

INSERT INTO `reportepartidaanuncio` (`id`, `idPartida`, `descripcion`, `resuelto`) VALUES
(1, 11, 'Holiiiiiiiiiiiii', 0),
(2, 11, 'Holiiiiiiiii', 0),
(3, 11, 'asdsad', 0),
(4, 11, 'JAJAJAJAJA', 0),
(5, 11, 'asdJAJAJJsskskllllll', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reporteusuario`
--

CREATE TABLE `reporteusuario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(5000) NOT NULL,
  `resuelto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `reporteusuario`
--

INSERT INTO `reporteusuario` (`id`, `idUsuario`, `descripcion`, `resuelto`) VALUES
(1, 2, 'asdasdasdasdasasdsad', 0),
(2, 2, 'Estoy', 0),
(3, 1, 'Esta imagen es mu mala, mu mala. asdsadasdasdadasdasdasdlaad asdada dadsads asdasd sd sdasdska kd kdlasdowls lasdlsdklasdakl ladkl sakd kwoasldlwasodk k dalsdlawdosdka sladwoalsdwo lasdw', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(125) NOT NULL,
  `contra` varchar(50) NOT NULL,
  `mail` varchar(125) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `foto` varchar(1000) DEFAULT '../images/usuarioIcono.png',
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `contra`, `mail`, `role`, `foto`, `estado`) VALUES
(1, 'prueba', 'Prueba12345', 'prueba@gmail.com', 0, '../images/usuarioIcono.png', 1),
(2, 'Leinad', 'Usuario21', 'usuario21@gmail.com', 0, '../images/LeinadBlep.png', 1),
(9, 'Usuario212', 'Usuario212', 'Usuario212@gmail.com', 0, '../images/usuarioIcono.png', 1),
(10, 'admin', 'admin', 'admin@admin.com', 1, '../images/usuarioIcono.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloqueados`
--
ALTER TABLE `bloqueados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bloq1_usu` (`idBloqueado`),
  ADD KEY `fk_bloq2_usu` (`idUsuario`);

--
-- Indexes for table `chatprivado`
--
ALTER TABLE `chatprivado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_chat1_usu` (`idUsuario1`),
  ADD KEY `fk_chat2_usu` (`idUsuario2`);

--
-- Indexes for table `foromensaje`
--
ALTER TABLE `foromensaje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_Men_Par` (`idAnuncio`),
  ADD KEY `FK_Men_Usu` (`idUser`);

--
-- Indexes for table `mensajeschatprivados`
--
ALTER TABLE `mensajeschatprivados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_mensajes_chat` (`idChat`),
  ADD KEY `fk_mensajes_usuario` (`idUsuario`);

--
-- Indexes for table `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_idCreador_usu` (`idCreador`);

--
-- Indexes for table `reportechatprivado`
--
ALTER TABLE `reportechatprivado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_repPriv_chat` (`idChat`),
  ADD KEY `fk_repPriv_mens` (`idMensaje`);

--
-- Indexes for table `reporteforomensaje`
--
ALTER TABLE `reporteforomensaje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_repForo_chat` (`idChat`),
  ADD KEY `fk_repForo_mensaje` (`idMensaje`);

--
-- Indexes for table `reportepartidaanuncio`
--
ALTER TABLE `reportepartidaanuncio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_reporte_partida` (`idPartida`);

--
-- Indexes for table `reporteusuario`
--
ALTER TABLE `reporteusuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_repUsu_usuario` (`idUsuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloqueados`
--
ALTER TABLE `bloqueados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `chatprivado`
--
ALTER TABLE `chatprivado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `foromensaje`
--
ALTER TABLE `foromensaje`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mensajeschatprivados`
--
ALTER TABLE `mensajeschatprivados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `partidas`
--
ALTER TABLE `partidas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reportechatprivado`
--
ALTER TABLE `reportechatprivado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reporteforomensaje`
--
ALTER TABLE `reporteforomensaje`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reportepartidaanuncio`
--
ALTER TABLE `reportepartidaanuncio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reporteusuario`
--
ALTER TABLE `reporteusuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bloqueados`
--
ALTER TABLE `bloqueados`
  ADD CONSTRAINT `fk_bloq1_usu` FOREIGN KEY (`idBloqueado`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bloq2_usu` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chatprivado`
--
ALTER TABLE `chatprivado`
  ADD CONSTRAINT `fk_chat1_usu` FOREIGN KEY (`idUsuario1`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chat2_usu` FOREIGN KEY (`idUsuario2`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `foromensaje`
--
ALTER TABLE `foromensaje`
  ADD CONSTRAINT `FK_Men_Par` FOREIGN KEY (`idAnuncio`) REFERENCES `partidas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Men_Usu` FOREIGN KEY (`idUser`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mensajeschatprivados`
--
ALTER TABLE `mensajeschatprivados`
  ADD CONSTRAINT `fk_mensajes_chat` FOREIGN KEY (`idChat`) REFERENCES `chatprivado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mensajes_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `fk_idCreador_usu` FOREIGN KEY (`idCreador`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reportechatprivado`
--
ALTER TABLE `reportechatprivado`
  ADD CONSTRAINT `fk_repPriv_chat` FOREIGN KEY (`idChat`) REFERENCES `chatprivado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_repPriv_mens` FOREIGN KEY (`idMensaje`) REFERENCES `mensajeschatprivados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reporteforomensaje`
--
ALTER TABLE `reporteforomensaje`
  ADD CONSTRAINT `fk_repForo_chat` FOREIGN KEY (`idChat`) REFERENCES `partidas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_repForo_mensaje` FOREIGN KEY (`idMensaje`) REFERENCES `foromensaje` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reportepartidaanuncio`
--
ALTER TABLE `reportepartidaanuncio`
  ADD CONSTRAINT `fk_reporte_partida` FOREIGN KEY (`idPartida`) REFERENCES `partidas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reporteusuario`
--
ALTER TABLE `reporteusuario`
  ADD CONSTRAINT `fk_repUsu_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
