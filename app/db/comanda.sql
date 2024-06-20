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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombreUsuario` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `clave` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ocupacion` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `fechaBaja` date DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `sector` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `tiempo` SMALLINT NOT NULL,
  `fechaBaja` date DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `mesa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigoMesa` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `estado` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `fechaBaja` date DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `pedido` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idMesa` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `codigoPedido` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `estado` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `tiempoEstimado` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `precioFinal` DECIMAL(10,2) NOT NULL,
  `foto` BLOB,
  `nombreCliente` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `fechaBaja` date DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE IF NOT EXISTS `config` (
  `id` bigint(20) unsigned NOT NULL,
  `claveSecreta` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `tipoEncriptacion` varchar(20) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcado de datos para la tabla `cds`
--

INSERT INTO `usuario` (`id`,`nombreUsuario`, `clave`, `ocupacion`, `fechaBaja`) VALUES
(1,'Beauty', 'T3sT$JWT', 'Mozo', NULL),
(3,'Nicolas', 'T5sJ$XWT', 'Cervecero', NULL),
(6,'Gaston', 'G3s6$JET', 'Bartender', NULL),
(7,'Sandra', 'R5gT$JWT', 'Cocinero', NULL);

INSERT INTO `productos` (`id`,`nombre`, `sector`,`precio`, `tiempo`, `fechaBaja`) VALUES
(1,'Hamburguesas',"Cocinero",10000, 15, NULL),
(3,'Vino', "Bartender",8500, 120, NULL), -- Cambiado a 120 minutos (2 horas)
(6,'Cerveza Brahama',"Cerveceria", 5000, 120, NULL), -- Cambiado a 120 minutos (2 horas)
(7,'Flan',"Candy Bar", 7500, 120, NULL); -- Cambiado a 120 minutos (2 horas)


INSERT INTO `mesa` (`id`,`codigoMesa`, `estado`, `fechaBaja`) VALUES
(1,'12345',"con cliente comiendo", NULL),
(3,'54789', "con cliente esperando pedido", NULL), -- Cambiado a 120 minutos (2 horas)
(6,'56123',"con cliente pagando", NULL), -- Cambiado a 120 minutos (2 horas)
(7,'98745',"cerrada", NULL);

INSERT INTO `pedido` (`id`,`idMesa`,`codigoPedido`,`estado`,`tiempoEstimado`,`precioFinal`, `foto`,`nombreCliente`,`fechaBaja`) VALUES
(1,'12345','54789','terminado',30,10000,'/img', 'Gaston', NULL),
(3,'54789', '12345','en preparacion',5,8500,'/img','Jose', NULL),
(6,'56123','95126','terminado',25,5000,'/img','Sandra', NULL),
(7,'98745','26194','terminado',55,7500,'/img','Maria', NULL);

INSERT INTO `config` (`id`,`claveSecreta`,`tipoEncriptacion`) VALUES
(1,'T3sT$JWT', 'HS256');


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