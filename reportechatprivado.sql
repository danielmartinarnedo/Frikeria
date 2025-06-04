-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 08:57 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reportechatprivado`
--
ALTER TABLE `reportechatprivado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_repPriv_chat` (`idChat`),
  ADD KEY `fk_repPriv_mens` (`idMensaje`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reportechatprivado`
--
ALTER TABLE `reportechatprivado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reportechatprivado`
--
ALTER TABLE `reportechatprivado`
  ADD CONSTRAINT `fk_repPriv_chat` FOREIGN KEY (`idChat`) REFERENCES `chatprivado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_repPriv_mens` FOREIGN KEY (`idMensaje`) REFERENCES `mensajeschatprivados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
