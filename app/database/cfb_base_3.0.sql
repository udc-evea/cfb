-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-10-2015 a las 19:09:38
-- Versión del servidor: 5.5.38
-- Versión de PHP: 5.4.32-2+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cfb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_ocupacional`
--

CREATE TABLE IF NOT EXISTS `categoria_ocupacional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `categoria_ocupacional`
--

INSERT INTO `categoria_ocupacional` (`id`, `categoria`) VALUES
(1, 'Obrero/Empleado'),
(2, 'Patrón'),
(3, 'Cuenta Propia'),
(4, 'Jubilado/Pensionado'),
(5, 'Ama de Casa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cfb_users`
--

CREATE TABLE IF NOT EXISTS `cfb_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreyapellido` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `perfil` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `cfb_users`
--

INSERT INTO `cfb_users` (`id`, `nombreyapellido`, `username`, `password`, `remember_token`, `perfil`) VALUES
(5, 'Guillermo Martinez', 'cfb', '$2y$10$zHSo.T6NVjOCgsMdowYk4uNWli.UfKR//tAcGBozA0TLOJaRsveQ2', '2hsVhPxc38NtijRhhZpIEp9mH14fHxNeptF2f9C7AKfemjl52vPy8ye6cVb3', 'Administrador'),
(6, 'Nicolás Fernández', 'nicofer', '$2y$10$PRKwgK6R2tfdL4QoUrE1F.FOiIxPlHMpBxsVD.RL6RTfc0vT8rlMy', 'G5ARxaMYraFIlvJZsNW5uUPhBovxcUbpP6aiw5HtBMuocdL5XlgwYlw6HLkc', 'Administrador'),
(7, 'Martín Pentucci', 'mppfiles', '$2y$10$8Ehi6jKLZGyq4yH7HIVgquJccKT3XxhGe8713MsE8xkJ4hUfhtQYC', 'nTsWtIlFmE1Anmn3Ov3q8AVqNKKDKmmaSsDGjLXNjZqYRNghgket5uhUlOR7', 'Creador'),
(8, 'Vianel Pugh', 'vianelp', '$2y$10$mxFSbXz3zTdoZzFJpoNWkeyJQu5nrZf4dJc4TlJe0XG653JcIchc2', 'PRg6hWL3RSc2UlvKTV0BX2azcY0wViw8HJCIHwA8ILrkthekfhI2rMrE0zGN', 'Colaborador'),
(9, 'Docente UDC', 'docenteudc', '$2y$10$RfnGuGrOurLcUwzWWb2ye.eMO990wTK1m.qSGjyM.dIQ3IRsmvBBO', 'G1fl9Ck2okBAwWiJSTuyoecJbY5O3TmoA5LeMffUuzQd8eShj0009Zpa4rG2', 'Colaborador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `con_quien_vive`
--

CREATE TABLE IF NOT EXISTS `con_quien_vive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `con_quien_vive`
--

INSERT INTO `con_quien_vive` (`id`, `descripcion`) VALUES
(1, 'Solo'),
(2, 'Padres y hermanos'),
(3, 'Residencia Universitaria'),
(4, 'Con compañeros'),
(5, 'Cónyuge e hijos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_carrera`
--

CREATE TABLE IF NOT EXISTS `inscripcion_carrera` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oferta_formativa_id` int(10) unsigned NOT NULL,
  `tipo_documento_cod` int(10) unsigned NOT NULL,
  `estado_inscripcion` int(10) unsigned NOT NULL DEFAULT '0',
  `documento` int(10) unsigned NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `sexo` char(1) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `nacionalidad_id` int(10) unsigned NOT NULL,
  `localidad_id` int(10) unsigned NOT NULL,
  `localidad_otra` varchar(100) DEFAULT NULL,
  `localidad_depto` varchar(80) NOT NULL DEFAULT 'RAWSON',
  `localidad_pcia_id` int(10) unsigned NOT NULL,
  `localidad_pcia_otra` varchar(100) DEFAULT NULL,
  `localidad_pais_id` int(10) unsigned NOT NULL,
  `localidad_pais_otro` varchar(100) DEFAULT NULL,
  `telefono_fijo` varchar(50) DEFAULT NULL,
  `telefono_celular` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_institucional` varchar(200) DEFAULT NULL,
  `cant_notificaciones` int(10) unsigned NOT NULL DEFAULT '0',
  `domicilio_procedencia_tipo` enum('CASA','DEPTO','PENSION','RESIDENCIA') NOT NULL,
  `domicilio_procedencia_calle` varchar(200) DEFAULT NULL,
  `domicilio_procedencia_nro` int(10) unsigned NOT NULL DEFAULT '0',
  `domicilio_procedencia_piso` tinyint(3) unsigned DEFAULT '0',
  `domicilio_procedencia_depto` varchar(5) DEFAULT '-',
  `domicilio_procedencia_localidad_id` int(10) unsigned NOT NULL,
  `domicilio_procedencia_localidad_otra` varchar(100) DEFAULT NULL,
  `domicilio_procedencia_cp` varchar(10) NOT NULL,
  `domicilio_procedencia_pcia_id` int(10) unsigned NOT NULL,
  `domicilio_procedencia_pcia_otra` varchar(100) DEFAULT NULL,
  `domicilio_procedencia_pais_id` int(10) unsigned NOT NULL,
  `domicilio_procedencia_pais_otro` varchar(100) DEFAULT NULL,
  `domicilio_clases_tipo` enum('CASA','DEPTO','PENSION','RESIDENCIA') NOT NULL,
  `domicilio_clases_calle` varchar(200) DEFAULT NULL,
  `domicilio_clases_nro` int(10) unsigned NOT NULL DEFAULT '0',
  `domicilio_clases_piso` tinyint(3) unsigned DEFAULT '0',
  `domicilio_clases_depto` varchar(5) DEFAULT '-',
  `domicilio_clases_cp` varchar(10) NOT NULL,
  `domicilio_clases_localidad_id` int(10) unsigned NOT NULL,
  `domicilio_clases_localidad_otra` varchar(100) DEFAULT NULL,
  `domicilio_clases_pcia_id` int(10) unsigned NOT NULL,
  `domicilio_clases_pcia_otra` varchar(100) DEFAULT NULL,
  `domicilio_clases_pais_id` int(10) unsigned NOT NULL,
  `domicilio_clases_pais_otro` varchar(100) DEFAULT NULL,
  `domicilio_clases_con_quien_vive_id` int(10) unsigned NOT NULL,
  `situacion_laboral` enum('TRABAJA','NO TRABAJA','DESOCUPADO') NOT NULL,
  `situacion_laboral_ocupacion` enum('TEMPORAL','PERMANENTE') DEFAULT NULL,
  `situacion_laboral_horas_semana` enum('MENOS DE 20','ENTRE 21 Y 35','36 O MAS') NOT NULL,
  `situacion_laboral_relacion_trabajo_carrera` enum('TOTAL','PARCIAL','NINGUNA') DEFAULT NULL,
  `situacion_laboral_categoria_ocupacional_id` int(10) unsigned DEFAULT NULL,
  `situacion_laboral_detalle_labor` text,
  `situacion_laboral_rama_id` int(10) unsigned DEFAULT NULL,
  `padre_apeynom` varchar(255) NOT NULL,
  `padre_vive` enum('SI','NO','NS/NC') NOT NULL,
  `padre_estudios_id` int(10) unsigned DEFAULT NULL,
  `padre_categoria_ocupacional_id` int(10) unsigned DEFAULT NULL,
  `padre_labor` text,
  `padre_ocupacion` enum('PERMANENTE','TEMPORARIA') DEFAULT NULL,
  `madre_apeynom` varchar(255) NOT NULL,
  `madre_vive` enum('SI','NO','NS/NC') NOT NULL,
  `madre_estudios_id` int(10) unsigned DEFAULT NULL,
  `madre_categoria_ocupacional_id` int(10) unsigned DEFAULT NULL,
  `madre_labor` text,
  `madre_ocupacion` enum('PERMANENTE','TEMPORARIA') DEFAULT NULL,
  `secundario_titulo_obtenido` varchar(200) NOT NULL,
  `secundario_anio_egreso` year(4) NOT NULL,
  `secundario_nombre_colegio` varchar(255) NOT NULL,
  `secundario_numero_colegio` int(10) unsigned DEFAULT NULL,
  `secundario_localidad_id` int(10) unsigned NOT NULL,
  `secundario_localidad_otra` varchar(100) DEFAULT NULL,
  `secundario_pcia_id` int(10) unsigned NOT NULL,
  `secundario_pcia_otra` varchar(100) DEFAULT NULL,
  `secundario_pais_id` int(10) unsigned NOT NULL,
  `secundario_pais_otro` varchar(100) DEFAULT NULL,
  `secundario_tipo_establecimiento` enum('ESTATAL','PRIVADO') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oferta_academica_id_2` (`oferta_formativa_id`,`tipo_documento_cod`,`documento`),
  UNIQUE KEY `fk_el_mail` (`oferta_formativa_id`,`email`),
  KEY `tipo_documento_cod` (`tipo_documento_cod`),
  KEY `documento` (`documento`),
  KEY `apellido` (`apellido`,`nombre`),
  KEY `oferta_academica_id` (`oferta_formativa_id`),
  KEY `fk_inscripcion_carrera_nacionalidad1_idx` (`nacionalidad_id`),
  KEY `fk_inscripcion_carrera_repo_localidad1_idx` (`localidad_id`),
  KEY `fk_inscripcion_carrera_repo_provincia1_idx` (`localidad_pcia_id`),
  KEY `fk_inscripcion_carrera_repo_pais1_idx` (`localidad_pais_id`),
  KEY `fk_inscripcion_carrera_repo_localidad2_idx` (`domicilio_procedencia_localidad_id`),
  KEY `fk_inscripcion_carrera_repo_pais2_idx` (`domicilio_procedencia_pais_id`),
  KEY `fk_inscripcion_carrera_repo_localidad3_idx` (`domicilio_clases_localidad_id`),
  KEY `fk_inscripcion_carrera_repo_pais3_idx` (`domicilio_clases_pais_id`),
  KEY `fk_inscripcion_carrera_categoria_ocupacional1_idx` (`situacion_laboral_categoria_ocupacional_id`),
  KEY `fk_inscripcion_carrera_categoria_ocupacional2_idx` (`padre_categoria_ocupacional_id`),
  KEY `fk_inscripcion_carrera_categoria_ocupacional3_idx` (`madre_categoria_ocupacional_id`),
  KEY `fk_inscripcion_carrera_repo_localidad4_idx` (`secundario_localidad_id`),
  KEY `fk_inscripcion_carrera_repo_provincia2_idx` (`secundario_pcia_id`),
  KEY `fk_inscripcion_carrera_repo_pais4_idx` (`secundario_pais_id`),
  KEY `fk_inscripcion_carrera_con_quien_vive1_idx` (`domicilio_clases_con_quien_vive_id`),
  KEY `fk_inscripcion_carrera_rama_actividad_laboral1_idx` (`situacion_laboral_rama_id`),
  KEY `fk_inscripcion_carrera_repo_nivel_estudios1_idx` (`padre_estudios_id`),
  KEY `fk_inscripcion_carrera_repo_nivel_estudios2_idx` (`madre_estudios_id`),
  KEY `fk_inscripcion_carrera_repo_provincia3_idx` (`domicilio_procedencia_pcia_id`),
  KEY `fk_inscripcion_carrera_repo_provincia4_idx` (`domicilio_clases_pcia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_como_te_enteraste`
--

CREATE TABLE IF NOT EXISTS `inscripcion_como_te_enteraste` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Volcado de datos para la tabla `inscripcion_como_te_enteraste`
--

INSERT INTO `inscripcion_como_te_enteraste` (`id`, `descripcion`) VALUES
(8, 'Diarios'),
(9, 'Radio'),
(10, 'TV'),
(11, 'Visita en las escuelas'),
(12, 'Web institucional'),
(99, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_evento`
--

CREATE TABLE IF NOT EXISTS `inscripcion_evento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oferta_formativa_id` int(10) unsigned NOT NULL,
  `tipo_documento_cod` char(3) NOT NULL,
  `estado_inscripcion` int(10) unsigned NOT NULL DEFAULT '0',
  `documento` int(10) unsigned NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `localidad_id` int(10) unsigned NOT NULL,
  `localidad_otra` varchar(100) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `email_institucional` varchar(200) DEFAULT NULL,
  `cant_notificaciones` int(10) unsigned NOT NULL DEFAULT '0',
  `telefono` varchar(50) NOT NULL,
  `como_te_enteraste` int(10) unsigned NOT NULL,
  `como_te_enteraste_otra` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inscripcion_evento_oferta_formativa1_idx` (`oferta_formativa_id`),
  KEY `fk_inscripcion_evento_inscripcion_como_te_enteraste1_idx` (`como_te_enteraste`),
  KEY `fk_inscripcion_evento_repo_localidad1_idx` (`localidad_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `inscripcion_evento`
--

INSERT INTO `inscripcion_evento` (`id`, `oferta_formativa_id`, `tipo_documento_cod`, `estado_inscripcion`, `documento`, `apellido`, `nombre`, `fecha_nacimiento`, `localidad_id`, `localidad_otra`, `email`, `email_institucional`, `cant_notificaciones`, `telefono`, `como_te_enteraste`, `como_te_enteraste_otra`) VALUES
(8, 7, '1', 0, 24956348, 'Dsfdasfd', 'Dsfsdfsdf', '2001-10-03', 89, '', 'ing.gmart@gmail.com', NULL, 0, '42562365', 8, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_oferta`
--

CREATE TABLE IF NOT EXISTS `inscripcion_oferta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oferta_formativa_id` int(10) unsigned NOT NULL,
  `tipo_documento_cod` char(3) NOT NULL,
  `estado_inscripcion` int(10) unsigned NOT NULL DEFAULT '0',
  `documento` int(10) unsigned NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `localidad_id` int(10) unsigned NOT NULL,
  `localidad_otra` varchar(100) DEFAULT NULL,
  `localidad_anios_residencia` int(10) unsigned NOT NULL,
  `nivel_estudios_id` int(10) unsigned NOT NULL,
  `titulo_obtenido` varchar(200) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `email_institucional` varchar(200) DEFAULT NULL,
  `cant_notificaciones` int(10) unsigned NOT NULL DEFAULT '0',
  `telefono` varchar(50) NOT NULL,
  `como_te_enteraste` int(10) unsigned NOT NULL,
  `como_te_enteraste_otra` varchar(255) DEFAULT NULL,
  `comision_nro` int(10) DEFAULT '0',
  `presento_requisitos` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oferta_academica_id_2` (`oferta_formativa_id`,`tipo_documento_cod`,`documento`),
  UNIQUE KEY `oferta_academica_id_3` (`oferta_formativa_id`,`email`),
  KEY `tipo_documento_cod` (`tipo_documento_cod`),
  KEY `localidad_id` (`localidad_id`),
  KEY `documento` (`documento`),
  KEY `apellido` (`apellido`,`nombre`),
  KEY `nivel_estudios_id` (`nivel_estudios_id`),
  KEY `oferta_academica_id` (`oferta_formativa_id`),
  KEY `fk_inscripcion_persona_inscripcion_como_te_enteraste1_idx` (`como_te_enteraste`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_requisito_presentado`
--

CREATE TABLE IF NOT EXISTS `inscripcion_requisito_presentado` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `requisito_id` int(10) unsigned NOT NULL,
  `inscripto_id` int(10) unsigned NOT NULL,
  `inscripto_type` varchar(100) NOT NULL,
  `fecha_presentacion` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inscripcion_requisito_presentado_oferta_requisitos1_idx` (`requisito_id`),
  KEY `inscripcion_id` (`inscripto_id`),
  KEY `requisito_id` (`requisito_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE IF NOT EXISTS `nacionalidad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `nacionalidad`
--

INSERT INTO `nacionalidad` (`id`, `descripcion`) VALUES
(1, 'Argentino/a'),
(2, 'Argentino/a Naturalizado/a'),
(3, 'Extranjero/a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_formativa`
--

CREATE TABLE IF NOT EXISTS `oferta_formativa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `anio` year(4) NOT NULL,
  `permite_inscripciones` tinyint(1) NOT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `terminos` text,
  `cupo_maximo` int(10) unsigned NOT NULL DEFAULT '0',
  `tiene_preinscripcion` tinyint(1) NOT NULL DEFAULT '0',
  `mail_bienvenida_file_name` varchar(255) DEFAULT NULL,
  `mail_bienvenida_file_size` int(11) DEFAULT NULL,
  `mail_bienvenida_content_type` varchar(255) DEFAULT NULL,
  `mail_bienvenida_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tipo_oferta` int(10) unsigned NOT NULL,
  `presentar_mas_doc` tinyint(1) NOT NULL DEFAULT '0',
  `doc_a_presentar` text,
  `user_id_creador` int(11) DEFAULT '0',
  `url_imagen_mail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oferta_formativa_tipo_oferta_formativa1_idx` (`tipo_oferta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `oferta_formativa`
--

INSERT INTO `oferta_formativa` (`id`, `nombre`, `anio`, `permite_inscripciones`, `inicio`, `fin`, `terminos`, `cupo_maximo`, `tiene_preinscripcion`, `mail_bienvenida_file_name`, `mail_bienvenida_file_size`, `mail_bienvenida_content_type`, `mail_bienvenida_updated_at`, `tipo_oferta`, `presentar_mas_doc`, `doc_a_presentar`, `user_id_creador`, `url_imagen_mail`) VALUES
(6, 'dfasdfsd', 2015, 0, '2015-10-10', '2015-10-21', 'dfsfsd', 0, 0, 'InscripcionTUP.jpg', 166188, 'image/jpeg', '2015-10-22 14:21:01', 1, 1, 'dsvsddsa', 5, 'http://udc.edu.ar'),
(7, 'Prueba', 2015, 1, '2015-10-01', '2015-10-31', 'm\r\nm\r\nm\r\nm\r\nm\r\nm', 0, 0, 'InscripcionTUP.jpg', 166188, 'image/jpeg', '2015-10-22 17:21:56', 3, 0, '', 6, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_requisitos`
--

CREATE TABLE IF NOT EXISTS `oferta_requisitos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oferta_id` int(10) unsigned NOT NULL,
  `requisito` varchar(200) NOT NULL,
  `obligatorio` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_oferta_requisitos_oferta_academicaa` (`oferta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rama_actividad_laboral`
--

CREATE TABLE IF NOT EXISTS `rama_actividad_laboral` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `rama_actividad_laboral`
--

INSERT INTO `rama_actividad_laboral` (`id`, `descripcion`) VALUES
(1, 'Agricultura, Ganaderia o Minería'),
(2, 'Industria y Construcción'),
(3, 'Comercio may. y Minor.'),
(4, 'Bancos, Bolsas, Seguros y Soc. Financ.'),
(5, 'Enseñanza'),
(6, 'Entes Civiles del Estado'),
(7, 'Fuerzas Armadas y de Seguridad'),
(8, 'Ejercicio de Profesión Liberal'),
(9, 'Serv. Públicos y Privados Part.'),
(10, 'Inst. Deportivas y Afines'),
(11, 'Artes en gral. y Afines'),
(12, 'Medios de Comunicación'),
(13, 'Ocupaciones varias'),
(14, 'Hogares Privados c/ Servicio Doméstico'),
(15, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_localidad`
--

CREATE TABLE IF NOT EXISTS `repo_localidad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `localidad` varchar(100) NOT NULL,
  `codigoPostal` varchar(10) DEFAULT NULL,
  `codigoTelArea` varchar(5) DEFAULT NULL,
  `latitud` decimal(17,14) DEFAULT NULL,
  `longitud` decimal(17,14) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Localidades de Argentina' AUTO_INCREMENT=115 ;

--
-- Volcado de datos para la tabla `repo_localidad`
--

INSERT INTO `repo_localidad` (`id`, `localidad`, `codigoPostal`, `codigoTelArea`, `latitud`, `longitud`) VALUES
(1, 'Rawson', NULL, NULL, NULL, NULL),
(87, 'Trelew', NULL, NULL, NULL, NULL),
(88, 'Gaiman', NULL, NULL, NULL, NULL),
(89, 'Puerto Madryn', NULL, NULL, NULL, NULL),
(99, ' Otra', NULL, NULL, NULL, NULL),
(100, 'Comodoro Rivadavia', NULL, NULL, NULL, NULL),
(101, 'Las Plumas', NULL, NULL, NULL, NULL),
(102, 'Paso de Indios', NULL, NULL, NULL, NULL),
(103, 'Esquel', NULL, NULL, NULL, NULL),
(104, 'Dique F. Ameghino', NULL, NULL, NULL, NULL),
(105, 'Sarmiento', NULL, NULL, NULL, NULL),
(106, 'Rada Tilly', NULL, NULL, NULL, NULL),
(107, 'Dolavon', NULL, NULL, NULL, NULL),
(108, 'El Maitén', NULL, NULL, NULL, NULL),
(109, 'Gobernador Costa', NULL, NULL, NULL, NULL),
(110, 'Lago Puelo', NULL, NULL, NULL, NULL),
(111, 'Playa Unión', NULL, NULL, NULL, NULL),
(112, 'Río Mayo', NULL, NULL, NULL, NULL),
(113, '28 de Julio', NULL, NULL, NULL, NULL),
(114, 'Trevelin', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_nivel_estudios`
--

CREATE TABLE IF NOT EXISTS `repo_nivel_estudios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nivel_estudios` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `repo_nivel_estudios`
--

INSERT INTO `repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES
(1, 'Sin estudios'),
(2, 'NS/NC'),
(3, 'Primario incompleto'),
(4, 'Primario completo'),
(5, 'Secundario incompleto'),
(6, 'Secundario completo'),
(7, 'Terciario'),
(8, 'Universitario incompleto'),
(9, 'Universitario completo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_pais`
--

CREATE TABLE IF NOT EXISTS `repo_pais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Volcado de datos para la tabla `repo_pais`
--

INSERT INTO `repo_pais` (`id`, `nombre`) VALUES
(1, 'Argentina'),
(2, 'Chile'),
(3, 'Colombia'),
(4, 'Bolivia'),
(5, 'Perú'),
(6, 'Cuba'),
(99, ' Otro'),
(100, 'Paraguay'),
(101, 'Uruguay'),
(102, 'España'),
(103, 'Francia'),
(104, 'Alemania'),
(105, 'Italia'),
(106, 'Portugal'),
(107, 'México'),
(108, 'Estados Unidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_provincia`
--

CREATE TABLE IF NOT EXISTS `repo_provincia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provincia` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Provincias Argentinas' AUTO_INCREMENT=119 ;

--
-- Volcado de datos para la tabla `repo_provincia`
--

INSERT INTO `repo_provincia` (`id`, `provincia`) VALUES
(1, 'Chubut'),
(2, 'Santa Cruz'),
(3, 'Córdoba'),
(4, 'Buenos Aires'),
(99, ' Otra'),
(100, 'Tierra del Fuego'),
(101, 'Río Negro'),
(102, 'La Pampa'),
(103, 'Corrientes'),
(104, 'Entre Ríos'),
(105, 'Misiones'),
(106, 'Neuquén'),
(107, 'Mendoza'),
(108, 'San Luis'),
(109, 'San Juan'),
(110, 'La Rioja'),
(111, 'Tucumán'),
(112, 'Catamarca'),
(113, 'Jujuy'),
(114, 'Salta'),
(115, 'Formosa'),
(116, 'Santiago del Estero'),
(117, 'Santa Fe'),
(118, 'Chaco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repo_tipo_documento`
--

CREATE TABLE IF NOT EXISTS `repo_tipo_documento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Codificacion utilizada por ANSeS' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `repo_tipo_documento`
--

INSERT INTO `repo_tipo_documento` (`id`, `descripcion`) VALUES
(1, 'DNI'),
(2, 'LC'),
(3, 'LE'),
(4, 'Pasaporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_oferta_formativa`
--

CREATE TABLE IF NOT EXISTS `tipo_oferta_formativa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) NOT NULL,
  `icono` varchar(50) NOT NULL DEFAULT 'fa-graduation-cap',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_oferta_formativa`
--

INSERT INTO `tipo_oferta_formativa` (`id`, `descripcion`, `icono`) VALUES
(1, 'Carrera Presencial', 'fa-university'),
(2, 'Curso/Taller', 'fa-graduation-cap'),
(3, 'Evento', 'fa-calendar');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscripcion_carrera`
--
ALTER TABLE `inscripcion_carrera`
  ADD CONSTRAINT `fk_inscripcion_carrera_categoria_ocupacional1` FOREIGN KEY (`situacion_laboral_categoria_ocupacional_id`) REFERENCES `categoria_ocupacional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_categoria_ocupacional2` FOREIGN KEY (`padre_categoria_ocupacional_id`) REFERENCES `categoria_ocupacional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_categoria_ocupacional3` FOREIGN KEY (`madre_categoria_ocupacional_id`) REFERENCES `categoria_ocupacional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_con_quien_vive1` FOREIGN KEY (`domicilio_clases_con_quien_vive_id`) REFERENCES `con_quien_vive` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_nacionalidad1` FOREIGN KEY (`nacionalidad_id`) REFERENCES `nacionalidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_oferta_formativa1` FOREIGN KEY (`oferta_formativa_id`) REFERENCES `oferta_formativa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_rama_actividad_laboral1` FOREIGN KEY (`situacion_laboral_rama_id`) REFERENCES `rama_actividad_laboral` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_localidad1` FOREIGN KEY (`localidad_id`) REFERENCES `repo_localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_localidad2` FOREIGN KEY (`domicilio_procedencia_localidad_id`) REFERENCES `repo_localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_localidad3` FOREIGN KEY (`domicilio_clases_localidad_id`) REFERENCES `repo_localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_localidad4` FOREIGN KEY (`secundario_localidad_id`) REFERENCES `repo_localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_nivel_estudios1` FOREIGN KEY (`padre_estudios_id`) REFERENCES `repo_nivel_estudios` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_nivel_estudios2` FOREIGN KEY (`madre_estudios_id`) REFERENCES `repo_nivel_estudios` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_pais1` FOREIGN KEY (`localidad_pais_id`) REFERENCES `repo_pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_pais2` FOREIGN KEY (`domicilio_procedencia_pais_id`) REFERENCES `repo_pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_pais3` FOREIGN KEY (`domicilio_clases_pais_id`) REFERENCES `repo_pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_pais4` FOREIGN KEY (`secundario_pais_id`) REFERENCES `repo_pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_provincia1` FOREIGN KEY (`localidad_pcia_id`) REFERENCES `repo_provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_provincia2` FOREIGN KEY (`secundario_pcia_id`) REFERENCES `repo_provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_provincia3` FOREIGN KEY (`domicilio_procedencia_pcia_id`) REFERENCES `repo_provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_provincia4` FOREIGN KEY (`domicilio_clases_pcia_id`) REFERENCES `repo_provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscripcion_carrera_repo_tipo_documento1` FOREIGN KEY (`tipo_documento_cod`) REFERENCES `repo_tipo_documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscripcion_evento`
--
ALTER TABLE `inscripcion_evento`
  ADD CONSTRAINT `fk_inscripcion_evento_inscripcion_como_te_enteraste1` FOREIGN KEY (`como_te_enteraste`) REFERENCES `inscripcion_como_te_enteraste` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscripcion_evento_oferta_formativa1` FOREIGN KEY (`oferta_formativa_id`) REFERENCES `oferta_formativa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscripcion_evento_repo_localidad1` FOREIGN KEY (`localidad_id`) REFERENCES `repo_localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscripcion_oferta`
--
ALTER TABLE `inscripcion_oferta`
  ADD CONSTRAINT `fk_inscripcion_persona_inscripcion_como_te_enteraste1` FOREIGN KEY (`como_te_enteraste`) REFERENCES `inscripcion_como_te_enteraste` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscripcion_persona_oferta_academica1` FOREIGN KEY (`oferta_formativa_id`) REFERENCES `oferta_formativa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `inscripcion_persona_ibfk_2` FOREIGN KEY (`localidad_id`) REFERENCES `repo_localidad` (`id`),
  ADD CONSTRAINT `inscripcion_persona_ibfk_3` FOREIGN KEY (`nivel_estudios_id`) REFERENCES `repo_nivel_estudios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripcion_requisito_presentado`
--
ALTER TABLE `inscripcion_requisito_presentado`
  ADD CONSTRAINT `fk_inscripcion_requisito_presentado_oferta_requisitos1` FOREIGN KEY (`requisito_id`) REFERENCES `oferta_requisitos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `oferta_formativa`
--
ALTER TABLE `oferta_formativa`
  ADD CONSTRAINT `fk_oferta_formativa_tipo_oferta_formativa1` FOREIGN KEY (`tipo_oferta`) REFERENCES `tipo_oferta_formativa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `oferta_requisitos`
--
ALTER TABLE `oferta_requisitos`
  ADD CONSTRAINT `fk_oferta_requisitos_oferta_academicaa` FOREIGN KEY (`oferta_id`) REFERENCES `oferta_formativa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
