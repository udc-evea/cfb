-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-09-2014 a las 16:35:25
-- Versión del servidor: 5.6.19-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.4

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

DROP TABLE IF EXISTS `cfb_users`;
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

INSERT INTO `cfb_users` (`id`, `nombre`, `username`, `password`, `remember_token`) VALUES
(2, 'Administrador CFB', 'cfb', '$2y$10$/gHcep7RVikdCDPRYPg8ZetftLpMks8vdhzwrs8zgjft3IjzEWZVy', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_persona`
--

DROP TABLE IF EXISTS `inscripcion_persona`;
CREATE TABLE IF NOT EXISTS `inscripcion_persona` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oferta_academica_id` int(10) unsigned NOT NULL,
  `tipo_documento_cod` char(3) DEFAULT NULL,
  `estado_inscripcion` int(10) unsigned NOT NULL DEFAULT '1',
  `documento` int(10) unsigned DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `nacionalidad_id` int(10) unsigned DEFAULT NULL,
  `localidad_id` int(10) unsigned DEFAULT NULL,
  `localidad_otra` varchar(100) DEFAULT NULL,
  `localidad_anios_residencia` int(10) unsigned DEFAULT NULL,
  `estado_civil` int(10) unsigned DEFAULT NULL,
  `hijos` int(10) unsigned DEFAULT NULL,
  `nivel_estudios_id` int(10) unsigned DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `titulo_obtenido` varchar(200) DEFAULT NULL,
  `domicilio_procedencia_tipo` int(10) unsigned DEFAULT NULL,
  `domicilio_procedencia_domicilio` varchar(200) DEFAULT NULL,
  `domicilio_procedencia_localidad_id` int(10) unsigned DEFAULT NULL,
  `domicilio_procedencia_pais_id` varchar(45) DEFAULT NULL,
  `domicilio_clases_tipo` int(10) unsigned DEFAULT NULL,
  `domicilio_clases_domicilio` varchar(200) DEFAULT NULL,
  `domicilio_clases_localidad_id` int(10) unsigned DEFAULT NULL,
  `situacion_laboral_id` int(10) unsigned DEFAULT NULL,
  `relacion_trabajo_carrera` int(10) unsigned DEFAULT NULL,
  `categoria_ocupacional` int(10) unsigned DEFAULT NULL,
  `detalle_labor` text,
  `padre_apeynom` varchar(255) DEFAULT NULL,
  `padre_vive` int(10) unsigned DEFAULT NULL,
  `padre_estudios` int(10) unsigned DEFAULT NULL,
  `padre_categoria_ocupacional` int(10) unsigned DEFAULT NULL,
  `padre_labor` text,
  `madre_apeynom` varchar(255) DEFAULT NULL,
  `madre_vive` int(10) unsigned DEFAULT NULL,
  `madre_estudios` int(10) unsigned DEFAULT NULL,
  `madre_categoria_ocupacional` int(10) unsigned DEFAULT NULL,
  `madre_labor` text,
  `como_te_enteraste` int(10) unsigned DEFAULT NULL,
  `inscripcion_persona_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`inscripcion_persona_id`),
  UNIQUE KEY `oferta_academica_id_2` (`oferta_academica_id`,`tipo_documento_cod`,`documento`),
  UNIQUE KEY `oferta_academica_id_3` (`oferta_academica_id`,`email`),
  KEY `tipo_documento_cod` (`tipo_documento_cod`),
  KEY `localidad_id` (`localidad_id`),
  KEY `documento` (`documento`),
  KEY `apellido` (`apellido`,`nombre`),
  KEY `nivel_estudios_id` (`nivel_estudios_id`),
  KEY `oferta_academica_id` (`oferta_academica_id`),
  KEY `fk_inscripcion_persona_encuesta_tipo_residencia1_idx` (`domicilio_procedencia_tipo`),
  KEY `fk_inscripcion_persona_encuesta_tipo_residencia2_idx` (`domicilio_clases_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=454 ;

--
-- Volcado de datos para la tabla `inscripcion_persona`
--

INSERT INTO `inscripcion_persona` (`id`, `oferta_academica_id`, `tipo_documento_cod`, `estado_inscripcion`, `documento`, `apellido`, `nombre`, `sexo`, `fecha_nacimiento`, `nacionalidad_id`, `localidad_id`, `localidad_otra`, `localidad_anios_residencia`, `estado_civil`, `hijos`, `nivel_estudios_id`, `email`, `telefono`, `titulo_obtenido`, `domicilio_procedencia_tipo`, `domicilio_procedencia_domicilio`, `domicilio_procedencia_localidad_id`, `domicilio_procedencia_pais_id`, `domicilio_clases_tipo`, `domicilio_clases_domicilio`, `domicilio_clases_localidad_id`, `situacion_laboral_id`, `relacion_trabajo_carrera`, `categoria_ocupacional`, `detalle_labor`, `padre_apeynom`, `padre_vive`, `padre_estudios`, `padre_categoria_ocupacional`, `padre_labor`, `madre_apeynom`, `madre_vive`, `madre_estudios`, `madre_categoria_ocupacional`, `madre_labor`, `como_te_enteraste`, `inscripcion_persona_id`) VALUES
(435, 5, 'DU', 1, 12312312, 'argento', 'josé', 'M', '2003-05-31', NULL, 57, '', 12, NULL, NULL, 4, 'me@example.com', '011-442177425', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(451, 5, 'DU', 1, 55464643, 'Perez', 'Juan', 'M', '2000-12-12', NULL, 57, '', 3, NULL, NULL, 5, 'euu@yo.com', '025-1252552', 'aaam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(452, 5, 'DU', 1, 55464644, 'Perez', 'Juan', 'M', '2000-12-12', NULL, 57, '', 3, NULL, NULL, 5, 'euu@yoz.com', '025-1252552', 'aaam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(453, 5, 'DU', 1, 55464646, 'Perez', 'Juan', 'M', '2000-12-12', NULL, 57, '', 3, NULL, NULL, 5, 'euuss@yoz.com', '025-1252552', 'aaam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_requisito_presentado`
--

DROP TABLE IF EXISTS `inscripcion_requisito_presentado`;
CREATE TABLE IF NOT EXISTS `inscripcion_requisito_presentado` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inscripcion_id` int(10) unsigned NOT NULL,
  `requisito_id` int(10) unsigned NOT NULL,
  `fecha_presentacion` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inscripcion_requisito_presentado_oferta_requisitos1_idx` (`requisito_id`),
  KEY `inscripcion_id` (`inscripcion_id`),
  KEY `requisito_id` (`requisito_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `inscripcion_requisito_presentado`
--

INSERT INTO `inscripcion_requisito_presentado` (`id`, `inscripcion_id`, `requisito_id`, `fecha_presentacion`) VALUES
(8, 435, 46, '2014-09-17'),
(10, 435, 48, '2014-09-17'),
(11, 435, 47, '2014-09-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_academica`
--

DROP TABLE IF EXISTS `oferta_academica`;
CREATE TABLE IF NOT EXISTS `oferta_academica` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `anio` year(4) NOT NULL,
  `permite_inscripciones` tinyint(1) NOT NULL,
  `vigente` tinyint(1) NOT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `terminos` text,
  `cupo_maximo` int(10) unsigned NOT NULL DEFAULT '0',
  `tiene_preinscripcion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `oferta_academica`
--

INSERT INTO `oferta_academica` (`id`, `nombre`, `anio`, `permite_inscripciones`, `vigente`, `inicio`, `fin`, `terminos`, `cupo_maximo`, `tiene_preinscripcion`) VALUES
(5, 'Curso de prueba', 2014, 1, 1, NULL, NULL, 'Términos y condiciones de servicio\r\n\r\nEstos términos y condiciones de servicio ("TOS", por sus siglas en inglés) contienen información relevante que debe leer de manera cuidadosa. Además, Commerce le aconseja que revise nuestra Política de privacidad.\r\n\r\nLas palabras "nosotros", "nuestro" y "Commerce" hacen referencia a Commerce Bank, ya sea a su matriz o subsidiarias y a cualquier agente, contratista independiente o asignado que Commerce, de acuerdo a su sola discreción, pueda involucrar dentro de la disposición del Sitio. Las palabras "usted" y "su" hacen referencia a los visitantes y usuarios de este Sitio. Como referencia para el término "Sitio" podemos incluir cualquier sitio de Commerce o servicio de Commerce que esté asociado y al que se pueda acceder de forma directa o indirecta por medio del Sitio de Commerce o sus sitios Web relacionados.\r\n\r\nAl utilizar el Sitio, usted celebra un acuerdo legal con Commerce para atenerse a estos TOS. Si no quiere estar ligado de alguna forma a estos TOS, entonces no ingrese al Sitio. La única solución en caso que no esté satisfecho con el Sitio, o con cualquier cosa que esté a disposición en éste, es renunciar al uso del Sitio o a los servicios específicos.\r\n\r\nAlgunos servicios que están disponibles por medio del Sitio pueden contener términos y condiciones de servicio que son aún más restrictivos que estos TOS. Tanto estos TOS como los términos y condiciones de servicio que corresponden a un servicio en particular tienen validez al momento de utilizar este Sitio. En el caso que exista un conflicto entre estos TOS y los términos y condiciones de servicio más restrictivos prevalecerá aquel que sea más restrictivo.\r\n\r\nCommerce se reserva el derecho a modificar en cualquier momento los TOS o las políticas correspondientes al uso del Sitio y a notificar al cliente a través de la versión actualizada de los TOS que se describen en este Sitio. Usted tiene la responsabilidad de revisar de forma frecuente los TOS. El uso continuado del Sitio después de cualquier modificación representa su consentimiento para aquellas modificaciones.\r\n\r\nCommerce, en el momento que estime conveniente, puede discontinuar o realizar modificaciones en la información, productos o servicios que se describen aquí. Cualquier información fechada se publica sólo de acuerdo a su fecha, y Commerce no tiene la obligación o responsabilidad de actualizar o corregir aquella información. Commerce se reserva el derecho a poner término a cualquier o todo ofrecimiento que se realiza por medio del sitio Web sin requerir de una notificación previa al usuario. Asimismo, el hecho de ofrecer información, productos o servicios a través de este Sitio no constituye una solicitud por parte de Commerce para que cualquier persona utilice aquella información, productos o servicios en las jurisdicciones donde la entrega de tal información, productos o servicios está prohibida por ley.', 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_requisitos`
--

DROP TABLE IF EXISTS `oferta_requisitos`;
CREATE TABLE IF NOT EXISTS `oferta_requisitos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oferta_id` int(10) unsigned NOT NULL,
  `requisito` varchar(200) NOT NULL,
  `obligatorio` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_oferta_requisitos_oferta_academicaa` (`oferta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Volcado de datos para la tabla `oferta_requisitos`
--

INSERT INTO `oferta_requisitos` (`id`, `oferta_id`, `requisito`, `obligatorio`) VALUES
(46, 5, 'uno obligatorio', 1),
(47, 5, 'otro obligatorio', 1),
(48, 5, 'uno opcional', 0),
(49, 5, 'otro mas', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_localidad`
--

DROP TABLE IF EXISTS `repo_localidad`;
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

DROP TABLE IF EXISTS `repo_nivel_estudios`;
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
-- Estructura de tabla para la tabla `repo_provincia`
--

DROP TABLE IF EXISTS `repo_provincia`;
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

DROP TABLE IF EXISTS `repo_tipo_documento`;
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
('LE', 'Libreta Enrolamiento'),
('PA', 'Pasaporte');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscripcion_persona`
--
ALTER TABLE `inscripcion_persona`
  ADD CONSTRAINT `fk_inscripcion_persona_oferta_academica1` FOREIGN KEY (`oferta_academica_id`) REFERENCES `oferta_academica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `inscripcion_persona_ibfk_2` FOREIGN KEY (`localidad_id`) REFERENCES `repo_localidad` (`id`),
  ADD CONSTRAINT `fk_inscripcion_persona_encuesta_tipo_residencia1` FOREIGN KEY (`domicilio_procedencia_tipo`) REFERENCES `encuesta_tipo_residencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_persona_encuesta_tipo_residencia2` FOREIGN KEY (`domicilio_clases_tipo`) REFERENCES `encuesta_tipo_residencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `inscripcion_persona_ibfk_1` FOREIGN KEY (`tipo_documento_cod`) REFERENCES `repo_tipo_documento` (`tipo_documento`),
  ADD CONSTRAINT `inscripcion_persona_ibfk_3` FOREIGN KEY (`nivel_estudios_id`) REFERENCES `repo_nivel_estudios` (`id`);

--
-- Filtros para la tabla `inscripcion_requisito_presentado`
--
ALTER TABLE `inscripcion_requisito_presentado`
  ADD CONSTRAINT `fk_inscripcion_requisito_presentado_inscripcion_persona1` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion_persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscripcion_requisito_presentado_oferta_requisitos1` FOREIGN KEY (`requisito_id`) REFERENCES `oferta_requisitos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `oferta_requisitos`
--
ALTER TABLE `oferta_requisitos`
  ADD CONSTRAINT `fk_oferta_requisitos_oferta_academicaa` FOREIGN KEY (`oferta_id`) REFERENCES `oferta_academica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `repo_localidad`
--
ALTER TABLE `repo_localidad`
  ADD CONSTRAINT `repo_localidad_ibfk_1` FOREIGN KEY (`codigo_provincia`) REFERENCES `repo_provincia` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
