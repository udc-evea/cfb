-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-09-2014 a las 22:42:10
-- Versión del servidor: 5.6.17-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cfb`
--
CREATE DATABASE IF NOT EXISTS `cfb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cfb`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cfb_users`
--

CREATE TABLE IF NOT EXISTS `cfb_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `cfb_users`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_datos_laborales`
--

CREATE TABLE IF NOT EXISTS `inscripcion_datos_laborales` (
  `inscripcion_id` int(10) unsigned NOT NULL,
  `trabajo_lugar` varchar(50) DEFAULT NULL,
  `trabajo_antiguedad` varchar(45) DEFAULT NULL,
  `trabajo_condicion` varchar(45) DEFAULT NULL,
  `trabajo_descripcion` varchar(45) DEFAULT NULL,
  `trabajo_anterior_lugar` varchar(50) DEFAULT NULL,
  `trabajo_anterior_descripcion` varchar(45) DEFAULT NULL,
  `trabajo_anterior_antiguedad` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`inscripcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_encuesta`
--

CREATE TABLE IF NOT EXISTS `inscripcion_encuesta` (
  `inscripcion_id` int(10) unsigned NOT NULL,
  `encuesta_1` text NOT NULL COMMENT 'Que te motiva a realizar este curso',
  `encuesta_2` text NOT NULL COMMENT 'Cuales son tus expectativas respecto a este curso',
  `encuesta_3` text NOT NULL COMMENT 'Cuales son tus competencias previas vinculadas a la tematica de este curso',
  `encuesta_4` text NOT NULL COMMENT 'Participas actualmente del desarrollo de algun proyecto productivo',
  `encuesta_5` text NOT NULL COMMENT 'Como te enteraste de este curso',
  `encuesta_6` text NOT NULL COMMENT 'Participas de una asociacion de productores o de alguna promocion de proyectos productivos con o sin vinculacion con el Estado',
  PRIMARY KEY (`inscripcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_persona`
--

CREATE TABLE IF NOT EXISTS `inscripcion_persona` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persona_id` int(10) unsigned NOT NULL,
  `oferta_academica_id` int(10) unsigned NOT NULL,
  `tipo_documento_cod` char(3) NOT NULL,
  `documento` int(10) unsigned NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `sexo` char(1) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `localidad_id` int(10) unsigned DEFAULT NULL,
  `localidad_otra` varchar(100) DEFAULT NULL,
  `localidad_anios_residencia` int(10) unsigned NOT NULL,
  `nivel_estudios_id` int(10) unsigned NOT NULL,
  `email` varchar(80) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `titulo_obtenido` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oferta_academica_id_2` (`oferta_academica_id`,`tipo_documento_cod`,`documento`),
  UNIQUE KEY `oferta_academica_id_3` (`oferta_academica_id`,`email`),
  KEY `tipo_documento_cod` (`tipo_documento_cod`),
  KEY `localidad_id` (`localidad_id`),
  KEY `documento` (`documento`),
  KEY `apellido` (`apellido`,`nombre`),
  KEY `nivel_estudios_id` (`nivel_estudios_id`),
  KEY `oferta_academica_id` (`oferta_academica_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=456 ;

--
-- Volcado de datos para la tabla `inscripcion_persona`
--

INSERT INTO `inscripcion_persona` (`id`, `persona_id`, `oferta_academica_id`, `tipo_documento_cod`, `documento`, `apellido`, `nombre`, `sexo`, `fecha_nacimiento`, `localidad_id`, `localidad_otra`, `localidad_anios_residencia`, `nivel_estudios_id`, `email`, `telefono`, `titulo_obtenido`) VALUES
(435, 0, 5, 'DU', 12312312, 'argento', 'josé', 'M', '2003-05-31', 57, '', 12, 4, 'me@example.com', '011-442177425', ''),
(451, 0, 5, 'DU', 55464643, 'Perez', 'Juan', 'M', '2000-12-12', 57, '', 3, 5, 'euu@yo.com', '025-1252552', 'aaam'),
(452, 0, 5, 'DU', 55464644, 'Perez', 'Juan', 'M', '2000-12-12', 57, '', 3, 5, 'euu@yoz.com', '025-1252552', 'aaam'),
(453, 0, 5, 'DU', 55464646, 'Perez', 'Juan', 'M', '2000-12-12', 57, '', 3, 5, 'euuss@yoz.com', '025-1252552', 'aaam'),
(454, 0, 5, 'DU', 14646462, 'Perez', 'Juan', 'M', '2000-12-12', 57, '', 3, 5, 'euuss@yozz.com', '025-1252552', 'aaam'),
(455, 0, 5, 'DU', 14646463, 'Perez', 'Juan', 'M', '2000-12-12', 57, '', 3, 5, 'euuss@yozzz.com', '025-1252552', 'aaam');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_academica`
--

CREATE TABLE IF NOT EXISTS `oferta_academica` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `anio` year(4) NOT NULL,
  `permite_inscripciones` tinyint(1) NOT NULL,
  `vigente` tinyint(1) NOT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `oferta_academica`
--

INSERT INTO `oferta_academica` (`id`, `nombre`, `anio`, `permite_inscripciones`, `vigente`, `inicio`, `fin`) VALUES
(5, 'Curso de prueba', 2014, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_localidad`
--

CREATE TABLE IF NOT EXISTS `repo_localidad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_provincia` char(1) NOT NULL DEFAULT '' COMMENT 'Código de provincia según ISO31662',
  `localidad` varchar(100) NOT NULL,
  `codigoPostal` varchar(10) NOT NULL,
  `codigoTelArea` varchar(5) NOT NULL,
  `latitud` decimal(17,14) NOT NULL,
  `longitud` decimal(17,14) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `codigo_provincia` (`codigo_provincia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Localidades de Argentina' AUTO_INCREMENT=87 ;

--
-- Volcado de datos para la tabla `repo_localidad`
--

INSERT INTO `repo_localidad` (`id`, `codigo_provincia`, `localidad`, `codigoPostal`, `codigoTelArea`, `latitud`, `longitud`) VALUES
(1, 'U', '28 de Julio', '', '02965', -43.34465563778664, -65.83900451660156),
(2, 'U', 'Aldea Apeleg', '', '02945', -44.68333300000000, -70.84999990000000),
(3, 'U', 'Aldea Beleiro', '', '02903', 0.00000000000000, 0.00000000000000),
(4, 'U', 'Aldea Epulef', '', '02945', 0.00000000000000, 0.00000000000000),
(5, 'U', 'Aldea Escolar', '', '02945', -43.11666700000000, -71.55000000000000),
(6, 'U', 'Alto Río Senguer', '', '02945', -45.04356550000000, -70.81775010000000),
(7, 'U', 'Arroyo Verde', '', '', -42.01216000000000, -65.30385090000000),
(8, 'U', 'Astra', '', '0297', -45.73333300000000, -67.49999990000000),
(9, 'U', 'Bahía Bustamante', '', '', -45.13333000000000, -66.53334000000000),
(10, 'U', 'Blancuntre', '', '', 0.00000000000000, 0.00000000000000),
(11, 'U', 'Buen Pasto', '', '02945', -45.08333300000000, -69.46666690000000),
(12, 'U', 'Buenos Aires Chico', '', '', -42.05000000000000, -71.21666690000000),
(13, 'U', 'Camarones', '', '0297', -44.79912100000000, -65.71816290000000),
(14, 'U', 'Carrenleufú', '', '02945', -43.56705400000000, -71.69237590000000),
(15, 'U', 'Cerro Cóndor', '', '02965', 0.00000000000000, 0.00000000000000),
(16, 'U', 'Cholila', '', '02945', -42.51666700000000, -71.44999990000000),
(17, 'U', 'Colan Conhué', '', '02945', -43.26667000000000, -69.85000000000000),
(18, 'U', 'Comodoro Rivadavia', '9000', '0297', -45.85828000000000, -67.47782100000000),
(19, 'U', 'Corcovado', '', '02945', -43.53934100000000, -71.47514300000000),
(20, 'U', 'Cushamen Centro', '', '02945', -42.38333300000000, -71.05000000000000),
(21, 'U', 'Diadema Argentina', '', '0297', -45.76630000000000, -67.66754000000000),
(22, 'U', 'Dique Florentino Ameghino', '', '02965', -43.71185000000000, -66.43158000000000),
(23, 'U', 'Doctor Ricardo Rojas', '', '02903', -45.57670280000000, -71.06234330000000),
(24, 'U', 'Dolavon', '', '02965', -43.30473770000000, -65.71519880000000),
(25, 'U', 'El Escorial', '', '', 0.00000000000000, 0.00000000000000),
(26, 'U', 'El Hoyo', '', '02944', -27.02362000000000, -63.23456000000000),
(27, 'U', 'El Maitén', '', '02945', -42.03333300000000, -71.14999990000000),
(28, 'U', 'El Mirasol', '', '02965', 0.00000000000000, 0.00000000000000),
(29, 'U', 'Epuyén', '', '02945', 0.00000000000000, 0.00000000000000),
(30, 'U', 'Esquel ', '9200', '02945', -42.91666700000000, -71.33333290000000),
(31, 'U', 'Facundo', '', '02903', 0.00000000000000, 0.00000000000000),
(32, 'U', 'Frontera de Río Pico', '', '', 0.00000000000000, 0.00000000000000),
(33, 'U', 'Gaiman', '', '02965', -43.28333300000000, -65.49999990000000),
(34, 'U', 'Gan Gan', '', '02965', 0.00000000000000, 0.00000000000000),
(35, 'U', 'Garayalde', '', '0297', 0.00000000000000, 0.00000000000000),
(36, 'U', 'Gastre', '', '02965', 0.00000000000000, 0.00000000000000),
(37, 'U', 'Gobernador Costa', '', '02945', 0.00000000000000, 0.00000000000000),
(38, 'U', 'Gualjaina', '', '02945', 0.00000000000000, 0.00000000000000),
(39, 'U', 'José de San Martín', '', '02945', 0.00000000000000, 0.00000000000000),
(40, 'U', 'Lago Blanco', '', '02903', 0.00000000000000, 0.00000000000000),
(41, 'U', 'Lago Epuyén', '', '', 0.00000000000000, 0.00000000000000),
(42, 'U', 'Lago Puelo', '', '02944', 0.00000000000000, 0.00000000000000),
(43, 'U', 'Lago Rosario', '', '', 0.00000000000000, 0.00000000000000),
(44, 'U', 'Lagunita Salada', '', '02965', 0.00000000000000, 0.00000000000000),
(45, 'U', 'Las Plumas', '', '02965', 0.00000000000000, 0.00000000000000),
(46, 'U', 'Leleque', '', '', 0.00000000000000, 0.00000000000000),
(47, 'U', 'Los Altares', '', '02965', 0.00000000000000, 0.00000000000000),
(48, 'U', 'Los Cipreses', '', '02945', 0.00000000000000, 0.00000000000000),
(49, 'U', 'Paso de Indios', '', '02965', 0.00000000000000, 0.00000000000000),
(50, 'U', 'Paso del Sapo', '', '02945', 0.00000000000000, 0.00000000000000),
(51, 'U', 'Playa Magagna', '', '', 0.00000000000000, 0.00000000000000),
(52, 'U', 'Playa Unión ', '', '02965', 0.00000000000000, 0.00000000000000),
(53, 'U', 'Puerto Madryn', '9120', '02965', 0.00000000000000, 0.00000000000000),
(54, 'U', 'Puerto Pirámides', '', '02965', 0.00000000000000, 0.00000000000000),
(55, 'U', 'Quinta El Mirador', '', '', 0.00000000000000, 0.00000000000000),
(56, 'U', 'Rada Tilly', '', '0297', 0.00000000000000, 0.00000000000000),
(57, 'U', 'Rawson', '9103', '02965', 0.00000000000000, 0.00000000000000),
(58, 'U', 'Río Mayo ', '', '02903', 0.00000000000000, 0.00000000000000),
(59, 'U', 'Río Pico', '', '02945', 0.00000000000000, 0.00000000000000),
(60, 'U', 'Sarmiento ', '', '0297', 0.00000000000000, 0.00000000000000),
(61, 'U', 'Tecka', '', '02945', 0.00000000000000, 0.00000000000000),
(62, 'U', 'Telsen', '', '02965', 0.00000000000000, 0.00000000000000),
(63, 'U', 'Trelew', '9100', '02965', 0.00000000000000, 0.00000000000000),
(64, 'U', 'Trevelin', '', '02945', 0.00000000000000, 0.00000000000000),
(65, 'U', 'Villa Futalaufquen', '', '02945', 0.00000000000000, 0.00000000000000),
(66, 'U', 'Yala Laubat', '', '02965', 0.00000000000000, 0.00000000000000),
(67, 'U', 'Bryn Gwyn', '', '02965', 0.00000000000000, 0.00000000000000),
(68, 'U', 'Cerro Centinela', '', '02945', 0.00000000000000, 0.00000000000000),
(69, 'U', 'Chacay Oeste', '', '02965', 0.00000000000000, 0.00000000000000),
(70, 'U', 'Costa de Gualjaina', '', '02945', 0.00000000000000, 0.00000000000000),
(71, 'U', 'Costa del Chubut', '', '02945', 0.00000000000000, 0.00000000000000),
(72, 'U', 'Dos Lagunas', '', '02945', 0.00000000000000, 0.00000000000000),
(73, 'U', 'Dr. Atilio Oscar Viglione', '', '02945', 0.00000000000000, 0.00000000000000),
(74, 'U', 'El Coihue', '', '02945', 0.00000000000000, 0.00000000000000),
(75, 'U', 'El Turbio', '', '02944', 0.00000000000000, 0.00000000000000),
(76, 'U', 'Fofo Cahuel', '', '02945', 0.00000000000000, 0.00000000000000),
(77, 'U', 'La Angostura', '', '02965', 0.00000000000000, 0.00000000000000),
(78, 'U', 'Lago Rivadavia', '', '02945', 0.00000000000000, 0.00000000000000),
(79, 'U', 'Las Golondrinas', '', '02944', 0.00000000000000, 0.00000000000000),
(80, 'U', 'Paraje Río Pico', '', '0297', 0.00000000000000, 0.00000000000000),
(81, 'U', 'Piedra Parada', '', '02945', 0.00000000000000, 0.00000000000000),
(82, 'U', 'Ranquil Huao', '', '02945', 0.00000000000000, 0.00000000000000),
(83, 'U', 'Río Percy', '', '02945', 0.00000000000000, 0.00000000000000),
(84, 'U', 'Sepaucal', '', '02965', 0.00000000000000, 0.00000000000000),
(85, 'U', 'Treorcky', '', '02965', 0.00000000000000, 0.00000000000000),
(86, 'U', 'Languiñeo', '9201', '02945', 0.00000000000000, 0.00000000000000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_nivel_estudios`
--

CREATE TABLE IF NOT EXISTS `repo_nivel_estudios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nivel_estudios` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `repo_nivel_estudios`
--

INSERT INTO `repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES
(1, 'Primario incompleto'),
(2, 'Primario completo'),
(3, 'Secundario incompleto'),
(4, 'Secundario completo'),
(5, 'Terciario/universitario incompleto'),
(6, 'Terciario/universitario completo'),
(7, 'Posgrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_persona`
--

CREATE TABLE IF NOT EXISTS `repo_persona` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_documento_cod` char(3) NOT NULL,
  `documento` int(10) unsigned NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `sexo` char(1) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `localidad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_documento_cod` (`tipo_documento_cod`),
  KEY `localidad_id` (`localidad_id`),
  KEY `documento` (`documento`),
  KEY `apellido` (`apellido`,`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_provincia`
--

CREATE TABLE IF NOT EXISTS `repo_provincia` (
  `provincia` varchar(255) NOT NULL,
  `id` char(1) NOT NULL COMMENT 'Código de provincia según ISO 3166-2:AR',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Provincias Argentinas';

--
-- Volcado de datos para la tabla `repo_provincia`
--

INSERT INTO `repo_provincia` (`provincia`, `id`) VALUES
('Salta', 'A'),
('Buenos Aires (Provincia)', 'B'),
('Ciudad Autónoma de Buenos Aires', 'C'),
('San Luis', 'D'),
('Entre Ríos', 'E'),
('La Rioja', 'F'),
('Santiago del Estero', 'G'),
('Chaco', 'H'),
('San Juan', 'J'),
('Catamarca', 'K'),
('La Pampa', 'L'),
('Mendoza', 'M'),
('Misiones', 'N'),
('Formosa', 'P'),
('Neuquén', 'Q'),
('Rio negro', 'R'),
('Santa Fe', 'S'),
('Tucumán', 'T'),
('Chubut', 'U'),
('Tierra del Fuego', 'V'),
('Corrientes', 'W'),
('Córdoba', 'X'),
('Jujuy', 'Y'),
('Santa Cruz', 'Z');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_tipo_documento`
--

CREATE TABLE IF NOT EXISTS `repo_tipo_documento` (
  `tipo_documento` char(3) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`tipo_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Codificacion utilizada por ANSeS';

--
-- Volcado de datos para la tabla `repo_tipo_documento`
--

INSERT INTO `repo_tipo_documento` (`tipo_documento`, `descripcion`) VALUES
('CI', 'Cédula de Identificación'),
('DU', 'Documento Único (DNI)'),
('LE', 'Libreta Enrolamiento');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscripcion_datos_laborales`
--
ALTER TABLE `inscripcion_datos_laborales`
  ADD CONSTRAINT `fk_inscripcion_datos_laborales_inscripcion_persona1` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion_persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscripcion_encuesta`
--
ALTER TABLE `inscripcion_encuesta`
  ADD CONSTRAINT `fk_inscripcion_encuesta_inscripcion_persona1` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion_persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscripcion_persona`
--
ALTER TABLE `inscripcion_persona`
  ADD CONSTRAINT `fk_inscripcion_persona_oferta_academica1` FOREIGN KEY (`oferta_academica_id`) REFERENCES `oferta_academica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `inscripcion_persona_ibfk_1` FOREIGN KEY (`tipo_documento_cod`) REFERENCES `repo_tipo_documento` (`tipo_documento`),
  ADD CONSTRAINT `inscripcion_persona_ibfk_2` FOREIGN KEY (`localidad_id`) REFERENCES `repo_localidad` (`id`),
  ADD CONSTRAINT `inscripcion_persona_ibfk_3` FOREIGN KEY (`nivel_estudios_id`) REFERENCES `repo_nivel_estudios` (`id`);

--
-- Filtros para la tabla `repo_localidad`
--
ALTER TABLE `repo_localidad`
  ADD CONSTRAINT `repo_localidad_ibfk_1` FOREIGN KEY (`codigo_provincia`) REFERENCES `repo_provincia` (`id`);

--
-- Filtros para la tabla `repo_persona`
--
ALTER TABLE `repo_persona`
  ADD CONSTRAINT `repo_persona_ibfk_1` FOREIGN KEY (`tipo_documento_cod`) REFERENCES `repo_tipo_documento` (`tipo_documento`),
  ADD CONSTRAINT `repo_persona_ibfk_2` FOREIGN KEY (`localidad_id`) REFERENCES `repo_localidad` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
