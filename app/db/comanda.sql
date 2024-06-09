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
  `nombre` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `sector` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
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
  `idMesa` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `codigoPedido` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `estado` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
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

INSERT INTO `productos` (`nombre`, `sector`,`precio`, `tiempo`, `id`) VALUES
('Hamburguesas',"Cocinero",10000, 15, 1),
('Vino', "Bartender",8500, 120, 3), -- Cambiado a 120 minutos (2 horas)
('Cerveza Brahama',"Cerveceria", 5000, 120, 6), -- Cambiado a 120 minutos (2 horas)
('Flan',"Candy Bar", 7500, 120, 7); -- Cambiado a 120 minutos (2 horas)


INSERT INTO `mesa` (`codigoMesa`, `estado`,`id`) VALUES
('12345',"con cliente comiendo", 1),
('54789', "con cliente esperando pedido", 3), -- Cambiado a 120 minutos (2 horas)
('56123',"con cliente pagando", 6), -- Cambiado a 120 minutos (2 horas)
('98745',"cerrada", 7);

INSERT INTO `pedido` (`idMesa`,`codigoPedido`,`estado`,`precioFinal`, `foto`,`nombreCliente`,`id`) VALUES
('12345','54789','terminado',10000,'/img', 'Gaston', 1),
('54789', '12345','en preparacion',8500,'/img','Jose', 3),
('56123','95126','terminado',5000,'/img','Sandra', 6),
('98745','26194','terminado',7500,'/img','Maria',7);



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