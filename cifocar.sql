-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 31-10-2017 a las 13:50:13
-- Versión del servidor: 5.5.54
-- Versión de PHP: 5.3.10-1ubuntu3.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cifocar`
--
CREATE DATABASE `cifocar` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `cifocar`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

DROP TABLE IF EXISTS `marcas`;
CREATE TABLE IF NOT EXISTS `marcas` (
  `marca` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  UNIQUE KEY `marca` (`marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`marca`) VALUES
('Citroen'),
('Ford'),
('Nissan'),
('Opel'),
('Renault'),
('Seat');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `privilegio` int(11) NOT NULL COMMENT '0-admin, 1-compras, 2-vendedor',
  `admin` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user`, `password`, `nombre`, `privilegio`, `admin`, `email`, `imagen`, `fecha`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Administrador Total', 0, 1, 'administrador@mail.cat', 'images/users/admin.png', '2017-10-26 07:24:58'),
(2, 'compras', '81dc9bdb52d04dc20036dbd8313ed055', 'Miguel Gutierrez', 1, 0, 'mgutierrez@mail.cat', 'images/users/compras.png', '2017-10-26 07:24:58'),
(3, 'ventas', '81dc9bdb52d04dc20036dbd8313ed055', 'Judit Sanchez', 2, 0, 'jsanchez@mail.cat', 'images/users/ventas.png', '2017-10-26 07:24:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
CREATE TABLE IF NOT EXISTS `vehiculos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `modelo` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `color` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `precio_venta` float NOT NULL,
  `precio_compra` float NOT NULL,
  `kms` int(11) NOT NULL,
  `caballos` int(11) NOT NULL,
  `fecha_venta` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL COMMENT '0-en venta, 1-reservado, 2-vendido, 3-devolución, 4-baja',
  `any_matriculacion` int(11) NOT NULL,
  `detalles` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `marca` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vendedor` (`vendedor`),
  KEY `marca` (`marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`vendedor`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vehiculos_ibfk_2` FOREIGN KEY (`marca`) REFERENCES `marcas` (`marca`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
