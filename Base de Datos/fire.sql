-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2019 a las 18:22:52
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fire`
--

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
(35, 3, 3, 'Paco A', '2019-06-03', '2019-06-09', 0),
(39, 3, 4, 'Fran', '2019-05-07', NULL, 1),
(40, 13, 4, 'Raul', '2019-06-07', '2019-06-08', 0);

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
(3, '2222 CCC', 1),
(4, '3333 DDD', 1),
(5, '4444 GGG', 0),
(6, '5555 HHH', 1),
(7, '6666 DDD', 1),
(8, '7777 HHH', 1),
(9, '8888 JJJ', 1),
(10, '9999 FJC', 1),
(11, '3333 FBC', 0),
(13, '1111 HHH', 0);

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
  MODIFY `in_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `ma_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
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
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`in_he`) REFERENCES `herramientas` (`he_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`in_ma`) REFERENCES `matriculas` (`ma_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
