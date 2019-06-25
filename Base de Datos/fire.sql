-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2019 a las 19:25:14
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


GRANT ALL PRIVILEGES ON *.* TO 'fire'@'%' IDENTIFIED BY PASSWORD '*6D8A04D2B3D8FCA626E2541F7463477A4F2A6602' WITH GRANT OPTION;

GRANT ALL PRIVILEGES ON `fire`.* TO 'fire'@'%';

GRANT ALL PRIVILEGES ON `fire\_%`.* TO 'fire'@'%';

--
-- Base de datos: `fire`
--
CREATE DATABASE IF NOT EXISTS `fire` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fire`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientas`
--

CREATE TABLE `herramientas` (
  `he_id` int(11) NOT NULL,
  `he_no` varchar(256) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `herramientas`
--

INSERT INTO `herramientas` (`he_id`, `he_no`) VALUES
(1, 'extintor'),
(2, 'lanza manguera'),
(3, 'motosierra'),
(4, 'portatil'),
(5, 'raton'),
(6, 'teclado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `in_id` int(11) NOT NULL,
  `in_ma` int(11) NOT NULL,
  `in_he` int(11) NOT NULL,
  `in_no` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `in_fs` date NOT NULL,
  `in_fe` date DEFAULT NULL,
  `in_es` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`in_id`, `in_ma`, `in_he`, `in_no`, `in_fs`, `in_fe`, `in_es`) VALUES
(19, 1, 1, 'Francisco', '2019-06-18', '2019-06-20', 0),
(23, 3, 6, 'Carlos', '2019-06-25', NULL, 1),
(24, 3, 5, 'Ricardo', '2019-06-25', '2019-06-25', 0),
(25, 3, 4, 'Jose', '2019-06-25', '2019-06-25', 0),
(26, 3, 5, 'Jose', '2019-06-25', NULL, 1),
(27, 3, 4, 'David', '2019-06-25', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `ma_id` int(11) NOT NULL,
  `ma_nu` text COLLATE utf8_spanish_ci NOT NULL,
  `ma_op` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`ma_id`, `ma_nu`, `ma_op`) VALUES
(1, '1111 FFF', 1),
(3, '2222 CCC', 1),
(4, '3333 DDD', 1),
(5, '4444 GGG', 0),
(6, '5555 HHH', 1),
(7, '6666 DDD', 1),
(8, '7777 HHH', 1),
(9, '8888 JJJ', 1),
(10, '9999 FJC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioadmin`
--

CREATE TABLE `usuarioadmin` (
  `usad_id` int(11) NOT NULL,
  `usad_correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usad_password` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarioadmin`
--

INSERT INTO `usuarioadmin` (`usad_id`, `usad_correo`, `usad_password`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD PRIMARY KEY (`he_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`in_id`),
  ADD KEY `in_ma` (`in_ma`),
  ADD KEY `in_he` (`in_he`),
  ADD KEY `in_ma_2` (`in_ma`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`ma_id`);

--
-- Indices de la tabla `usuarioadmin`
--
ALTER TABLE `usuarioadmin`
  ADD PRIMARY KEY (`usad_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  MODIFY `he_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `in_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `ma_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `usuarioadmin`
--
ALTER TABLE `usuarioadmin`
  MODIFY `usad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`in_ma`) REFERENCES `matriculas` (`ma_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`in_he`) REFERENCES `herramientas` (`he_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
