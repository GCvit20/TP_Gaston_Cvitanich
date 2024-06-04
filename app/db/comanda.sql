-- Active: 1717177888678@@127.0.0.1@3307@tp
-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2016 a las 23:58:20
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cdcol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cds`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `nombreEmpleado` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `ocupacion` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `productos` (
  `tipoProducto` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `tiempo` SMALLINT NOT NULL,
  `id` bigint(20) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `mesa` (
  `codigoMesa` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `estado` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `pedido` (
  `codigoPedido` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `estado` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `tiempo` SMALLINT NOT NULL,
  `precioFinal` DECIMAL(10,2) NOT NULL,
  `foto` BLOB,
  `nombreCliente` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcado de datos para la tabla `cds`
--

INSERT INTO `usuario` (`nombreEmpleado`, `ocupacion`, `id`) VALUES
('Beauty', 'Mozo', 1),
('Nicolas', 'Cervecero', 3),
('Gaston', 'Bartender', 6),
('Sandra', 'Cocinero', 7);

INSERT INTO `productos` (`tipoProducto`, `precio`, `tiempo`, `id`) VALUES
('Hamburguesas', 10000, 15, 1),
('Vino', 8500, 120, 3), -- Cambiado a 120 minutos (2 horas)
('Cerveza Brahama', 5000, 120, 6), -- Cambiado a 120 minutos (2 horas)
('Vodka', 7500, 120, 7); -- Cambiado a 120 minutos (2 horas)


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cds`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cds`
--
ALTER TABLE `usuario`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;