CREATE DATABASE  IF NOT EXISTS `cfb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cfb`;
-- MySQL dump 10.13  Distrib 5.6.19, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cfb
-- ------------------------------------------------------
-- Server version	5.6.19-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cfb_users`
--

DROP TABLE IF EXISTS `cfb_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cfb_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cfb_users`
--

LOCK TABLES `cfb_users` WRITE;
/*!40000 ALTER TABLE `cfb_users` DISABLE KEYS */;
INSERT INTO `cfb_users` VALUES (5,'Administrador CFB','cfb','$2y$10$da28NKnSh2ag28fAcq2wO.OfCkmiGHLAIq39qPtixDnV3PWrJX.SC',NULL);
/*!40000 ALTER TABLE `cfb_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encuesta_tipo_residencia`
--

DROP TABLE IF EXISTS `encuesta_tipo_residencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encuesta_tipo_residencia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuesta_tipo_residencia`
--

LOCK TABLES `encuesta_tipo_residencia` WRITE;
/*!40000 ALTER TABLE `encuesta_tipo_residencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `encuesta_tipo_residencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion_carrera`
--

DROP TABLE IF EXISTS `inscripcion_carrera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscripcion_carrera` (
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
  `como_te_enteraste` int(10) unsigned NOT NULL,
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
  KEY `fk_inscripcion_persona_encuesta_tipo_residencia2_idx` (`domicilio_clases_tipo`),
  KEY `fk_inscripcion_persona_inscripcion_como_te_enteraste1_idx` (`como_te_enteraste`),
  CONSTRAINT `fk_inscripcion_persona_oferta_academica10` FOREIGN KEY (`oferta_academica_id`) REFERENCES `oferta_formativa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `inscripcion_persona_ibfk_10` FOREIGN KEY (`tipo_documento_cod`) REFERENCES `repo_tipo_documento` (`tipo_documento`),
  CONSTRAINT `inscripcion_persona_ibfk_20` FOREIGN KEY (`localidad_id`) REFERENCES `repo_localidad` (`id`),
  CONSTRAINT `inscripcion_persona_ibfk_30` FOREIGN KEY (`nivel_estudios_id`) REFERENCES `repo_nivel_estudios` (`id`),
  CONSTRAINT `fk_inscripcion_persona_encuesta_tipo_residencia10` FOREIGN KEY (`domicilio_procedencia_tipo`) REFERENCES `encuesta_tipo_residencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_persona_encuesta_tipo_residencia20` FOREIGN KEY (`domicilio_clases_tipo`) REFERENCES `encuesta_tipo_residencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_persona_inscripcion_como_te_enteraste10` FOREIGN KEY (`como_te_enteraste`) REFERENCES `inscripcion_como_te_enteraste` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=426 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion_carrera`
--

LOCK TABLES `inscripcion_carrera` WRITE;
/*!40000 ALTER TABLE `inscripcion_carrera` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscripcion_carrera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion_como_te_enteraste`
--

DROP TABLE IF EXISTS `inscripcion_como_te_enteraste`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscripcion_como_te_enteraste` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion_como_te_enteraste`
--

LOCK TABLES `inscripcion_como_te_enteraste` WRITE;
/*!40000 ALTER TABLE `inscripcion_como_te_enteraste` DISABLE KEYS */;
INSERT INTO `inscripcion_como_te_enteraste` VALUES (1,'Diarios'),(2,'Radio'),(3,'TV'),(4,'Un amigo / familiar / vecino'),(5,'Visita en las escuelas'),(6,'Web institucional'),(7,'Otro');
/*!40000 ALTER TABLE `inscripcion_como_te_enteraste` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion_oferta`
--

DROP TABLE IF EXISTS `inscripcion_oferta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscripcion_oferta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oferta_formativa_id` int(10) unsigned NOT NULL,
  `tipo_documento_cod` char(3) NOT NULL,
  `estado_inscripcion` int(10) unsigned NOT NULL DEFAULT '1',
  `documento` int(10) unsigned NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `localidad_id` int(10) unsigned NOT NULL,
  `localidad_otra` varchar(100) DEFAULT NULL,
  `localidad_anios_residencia` int(10) unsigned NOT NULL,
  `nivel_estudios_id` int(10) unsigned NOT NULL,
  `titulo_obtenido` varchar(200) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `como_te_enteraste` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oferta_academica_id_2` (`oferta_formativa_id`,`tipo_documento_cod`,`documento`),
  UNIQUE KEY `oferta_academica_id_3` (`oferta_formativa_id`,`email`),
  KEY `tipo_documento_cod` (`tipo_documento_cod`),
  KEY `localidad_id` (`localidad_id`),
  KEY `documento` (`documento`),
  KEY `apellido` (`apellido`,`nombre`),
  KEY `nivel_estudios_id` (`nivel_estudios_id`),
  KEY `oferta_academica_id` (`oferta_formativa_id`),
  KEY `fk_inscripcion_persona_inscripcion_como_te_enteraste1_idx` (`como_te_enteraste`),
  CONSTRAINT `fk_inscripcion_persona_oferta_academica1` FOREIGN KEY (`oferta_formativa_id`) REFERENCES `oferta_formativa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `inscripcion_persona_ibfk_1` FOREIGN KEY (`tipo_documento_cod`) REFERENCES `repo_tipo_documento` (`tipo_documento`),
  CONSTRAINT `inscripcion_persona_ibfk_2` FOREIGN KEY (`localidad_id`) REFERENCES `repo_localidad` (`id`),
  CONSTRAINT `inscripcion_persona_ibfk_3` FOREIGN KEY (`nivel_estudios_id`) REFERENCES `repo_nivel_estudios` (`id`),
  CONSTRAINT `fk_inscripcion_persona_inscripcion_como_te_enteraste1` FOREIGN KEY (`como_te_enteraste`) REFERENCES `inscripcion_como_te_enteraste` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=429 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion_oferta`
--

LOCK TABLES `inscripcion_oferta` WRITE;
/*!40000 ALTER TABLE `inscripcion_oferta` DISABLE KEYS */;
INSERT INTO `inscripcion_oferta` VALUES (427,2,'DU',1,25612323,'Argento','Jose','1980-10-24',57,'',11,2,'nada..-.','pepe@argento.com','1123333',2),(428,2,'DU',1,34453345,'sdfs','dfgdf','2000-10-03',57,'',5,4,'sdfsdf','ssds@sddsds.com','234234234',1);
/*!40000 ALTER TABLE `inscripcion_oferta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion_requisito_presentado`
--

DROP TABLE IF EXISTS `inscripcion_requisito_presentado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscripcion_requisito_presentado` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inscripcion_id` int(10) unsigned NOT NULL,
  `requisito_id` int(10) unsigned NOT NULL,
  `fecha_presentacion` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inscripcion_requisito_presentado_oferta_requisitos1_idx` (`requisito_id`),
  KEY `inscripcion_id` (`inscripcion_id`),
  KEY `requisito_id` (`requisito_id`),
  CONSTRAINT `fk_inscripcion_requisito_presentado_inscripcion_persona1` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripcion_oferta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_inscripcion_requisito_presentado_oferta_requisitos1` FOREIGN KEY (`requisito_id`) REFERENCES `oferta_requisitos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion_requisito_presentado`
--

LOCK TABLES `inscripcion_requisito_presentado` WRITE;
/*!40000 ALTER TABLE `inscripcion_requisito_presentado` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscripcion_requisito_presentado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta_formativa`
--

DROP TABLE IF EXISTS `oferta_formativa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oferta_formativa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `anio` year(4) NOT NULL,
  `permite_inscripciones` tinyint(1) NOT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `terminos` text,
  `cupo_maximo` int(10) unsigned NOT NULL DEFAULT '0',
  `tiene_preinscripcion` tinyint(1) NOT NULL DEFAULT '0',
  `mail_bienvenida` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta_formativa`
--

LOCK TABLES `oferta_formativa` WRITE;
/*!40000 ALTER TABLE `oferta_formativa` DISABLE KEYS */;
INSERT INTO `oferta_formativa` VALUES (2,'Primer Curso',2014,1,'2014-10-13','2014-10-20','blablabla',0,0,'');
/*!40000 ALTER TABLE `oferta_formativa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta_requisitos`
--

DROP TABLE IF EXISTS `oferta_requisitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oferta_requisitos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oferta_id` int(10) unsigned NOT NULL,
  `requisito` varchar(200) NOT NULL,
  `obligatorio` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_oferta_requisitos_oferta_academicaa` (`oferta_id`),
  CONSTRAINT `fk_oferta_requisitos_oferta_academicaa` FOREIGN KEY (`oferta_id`) REFERENCES `oferta_formativa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta_requisitos`
--

LOCK TABLES `oferta_requisitos` WRITE;
/*!40000 ALTER TABLE `oferta_requisitos` DISABLE KEYS */;
INSERT INTO `oferta_requisitos` VALUES (1,2,'Fotocopia de DNI',1),(4,2,'otra',0),(5,2,'ebdfbgdfg',1),(7,2,'fff',1);
/*!40000 ALTER TABLE `oferta_requisitos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repo_localidad`
--

DROP TABLE IF EXISTS `repo_localidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repo_localidad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_provincia` char(1) NOT NULL DEFAULT '' COMMENT 'Código de provincia según ISO31662',
  `localidad` varchar(100) NOT NULL,
  `codigoPostal` varchar(10) NOT NULL,
  `codigoTelArea` varchar(5) NOT NULL,
  `latitud` decimal(17,14) NOT NULL,
  `longitud` decimal(17,14) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `codigo_provincia` (`codigo_provincia`),
  CONSTRAINT `repo_localidad_ibfk_1` FOREIGN KEY (`codigo_provincia`) REFERENCES `repo_provincia` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 COMMENT='Localidades de Argentina';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repo_localidad`
--

LOCK TABLES `repo_localidad` WRITE;
/*!40000 ALTER TABLE `repo_localidad` DISABLE KEYS */;
INSERT INTO `repo_localidad` VALUES (1,'U','28 de Julio','','02965',-43.34465563778664,-65.83900451660156),(2,'U','Aldea Apeleg','','02945',-44.68333300000000,-70.84999990000000),(3,'U','Aldea Beleiro','','02903',0.00000000000000,0.00000000000000),(4,'U','Aldea Epulef','','02945',0.00000000000000,0.00000000000000),(5,'U','Aldea Escolar','','02945',-43.11666700000000,-71.55000000000000),(6,'U','Alto Río Senguer','','02945',-45.04356550000000,-70.81775010000000),(7,'U','Arroyo Verde','','',-42.01216000000000,-65.30385090000000),(8,'U','Astra','','0297',-45.73333300000000,-67.49999990000000),(9,'U','Bahía Bustamante','','',-45.13333000000000,-66.53334000000000),(10,'U','Blancuntre','','',0.00000000000000,0.00000000000000),(11,'U','Buen Pasto','','02945',-45.08333300000000,-69.46666690000000),(12,'U','Buenos Aires Chico','','',-42.05000000000000,-71.21666690000000),(13,'U','Camarones','','0297',-44.79912100000000,-65.71816290000000),(14,'U','Carrenleufú','','02945',-43.56705400000000,-71.69237590000000),(15,'U','Cerro Cóndor','','02965',0.00000000000000,0.00000000000000),(16,'U','Cholila','','02945',-42.51666700000000,-71.44999990000000),(17,'U','Colan Conhué','','02945',-43.26667000000000,-69.85000000000000),(18,'U','Comodoro Rivadavia','9000','0297',-45.85828000000000,-67.47782100000000),(19,'U','Corcovado','','02945',-43.53934100000000,-71.47514300000000),(20,'U','Cushamen Centro','','02945',-42.38333300000000,-71.05000000000000),(21,'U','Diadema Argentina','','0297',-45.76630000000000,-67.66754000000000),(22,'U','Dique Florentino Ameghino','','02965',-43.71185000000000,-66.43158000000000),(23,'U','Doctor Ricardo Rojas','','02903',-45.57670280000000,-71.06234330000000),(24,'U','Dolavon','','02965',-43.30473770000000,-65.71519880000000),(25,'U','El Escorial','','',0.00000000000000,0.00000000000000),(26,'U','El Hoyo','','02944',-27.02362000000000,-63.23456000000000),(27,'U','El Maitén','','02945',-42.03333300000000,-71.14999990000000),(28,'U','El Mirasol','','02965',0.00000000000000,0.00000000000000),(29,'U','Epuyén','','02945',0.00000000000000,0.00000000000000),(30,'U','Esquel ','9200','02945',-42.91666700000000,-71.33333290000000),(31,'U','Facundo','','02903',0.00000000000000,0.00000000000000),(32,'U','Frontera de Río Pico','','',0.00000000000000,0.00000000000000),(33,'U','Gaiman','','02965',-43.28333300000000,-65.49999990000000),(34,'U','Gan Gan','','02965',0.00000000000000,0.00000000000000),(35,'U','Garayalde','','0297',0.00000000000000,0.00000000000000),(36,'U','Gastre','','02965',0.00000000000000,0.00000000000000),(37,'U','Gobernador Costa','','02945',0.00000000000000,0.00000000000000),(38,'U','Gualjaina','','02945',0.00000000000000,0.00000000000000),(39,'U','José de San Martín','','02945',0.00000000000000,0.00000000000000),(40,'U','Lago Blanco','','02903',0.00000000000000,0.00000000000000),(41,'U','Lago Epuyén','','',0.00000000000000,0.00000000000000),(42,'U','Lago Puelo','','02944',0.00000000000000,0.00000000000000),(43,'U','Lago Rosario','','',0.00000000000000,0.00000000000000),(44,'U','Lagunita Salada','','02965',0.00000000000000,0.00000000000000),(45,'U','Las Plumas','','02965',0.00000000000000,0.00000000000000),(46,'U','Leleque','','',0.00000000000000,0.00000000000000),(47,'U','Los Altares','','02965',0.00000000000000,0.00000000000000),(48,'U','Los Cipreses','','02945',0.00000000000000,0.00000000000000),(49,'U','Paso de Indios','','02965',0.00000000000000,0.00000000000000),(50,'U','Paso del Sapo','','02945',0.00000000000000,0.00000000000000),(51,'U','Playa Magagna','','',0.00000000000000,0.00000000000000),(52,'U','Playa Unión ','','02965',0.00000000000000,0.00000000000000),(53,'U','Puerto Madryn','9120','02965',0.00000000000000,0.00000000000000),(54,'U','Puerto Pirámides','','02965',0.00000000000000,0.00000000000000),(55,'U','Quinta El Mirador','','',0.00000000000000,0.00000000000000),(56,'U','Rada Tilly','','0297',0.00000000000000,0.00000000000000),(57,'U','Rawson','9103','02965',0.00000000000000,0.00000000000000),(58,'U','Río Mayo ','','02903',0.00000000000000,0.00000000000000),(59,'U','Río Pico','','02945',0.00000000000000,0.00000000000000),(60,'U','Sarmiento ','','0297',0.00000000000000,0.00000000000000),(61,'U','Tecka','','02945',0.00000000000000,0.00000000000000),(62,'U','Telsen','','02965',0.00000000000000,0.00000000000000),(63,'U','Trelew','9100','02965',0.00000000000000,0.00000000000000),(64,'U','Trevelin','','02945',0.00000000000000,0.00000000000000),(65,'U','Villa Futalaufquen','','02945',0.00000000000000,0.00000000000000),(66,'U','Yala Laubat','','02965',0.00000000000000,0.00000000000000),(67,'U','Bryn Gwyn','','02965',0.00000000000000,0.00000000000000),(68,'U','Cerro Centinela','','02945',0.00000000000000,0.00000000000000),(69,'U','Chacay Oeste','','02965',0.00000000000000,0.00000000000000),(70,'U','Costa de Gualjaina','','02945',0.00000000000000,0.00000000000000),(71,'U','Costa del Chubut','','02945',0.00000000000000,0.00000000000000),(72,'U','Dos Lagunas','','02945',0.00000000000000,0.00000000000000),(73,'U','Dr. Atilio Oscar Viglione','','02945',0.00000000000000,0.00000000000000),(74,'U','El Coihue','','02945',0.00000000000000,0.00000000000000),(75,'U','El Turbio','','02944',0.00000000000000,0.00000000000000),(76,'U','Fofo Cahuel','','02945',0.00000000000000,0.00000000000000),(77,'U','La Angostura','','02965',0.00000000000000,0.00000000000000),(78,'U','Lago Rivadavia','','02945',0.00000000000000,0.00000000000000),(79,'U','Las Golondrinas','','02944',0.00000000000000,0.00000000000000),(80,'U','Paraje Río Pico','','0297',0.00000000000000,0.00000000000000),(81,'U','Piedra Parada','','02945',0.00000000000000,0.00000000000000),(82,'U','Ranquil Huao','','02945',0.00000000000000,0.00000000000000),(83,'U','Río Percy','','02945',0.00000000000000,0.00000000000000),(84,'U','Sepaucal','','02965',0.00000000000000,0.00000000000000),(85,'U','Treorcky','','02965',0.00000000000000,0.00000000000000),(86,'U','Languiñeo','9201','02945',0.00000000000000,0.00000000000000),(99,'U','Otra','','',0.00000000000000,0.00000000000000);
/*!40000 ALTER TABLE `repo_localidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repo_nivel_estudios`
--

DROP TABLE IF EXISTS `repo_nivel_estudios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repo_nivel_estudios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nivel_estudios` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repo_nivel_estudios`
--

LOCK TABLES `repo_nivel_estudios` WRITE;
/*!40000 ALTER TABLE `repo_nivel_estudios` DISABLE KEYS */;
INSERT INTO `repo_nivel_estudios` VALUES (1,'Primario incompleto'),(2,'Primario completo'),(3,'Secundario incompleto'),(4,'Secundario completo'),(5,'Terciario/universitario incompleto'),(6,'Terciario/universitario completo'),(7,'Posgrado');
/*!40000 ALTER TABLE `repo_nivel_estudios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repo_pais`
--

DROP TABLE IF EXISTS `repo_pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repo_pais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `codigo` char(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repo_pais`
--

LOCK TABLES `repo_pais` WRITE;
/*!40000 ALTER TABLE `repo_pais` DISABLE KEYS */;
/*!40000 ALTER TABLE `repo_pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repo_provincia`
--

DROP TABLE IF EXISTS `repo_provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repo_provincia` (
  `provincia` varchar(255) NOT NULL,
  `id` char(1) NOT NULL COMMENT 'Código de provincia según ISO 3166-2:AR',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Provincias Argentinas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repo_provincia`
--

LOCK TABLES `repo_provincia` WRITE;
/*!40000 ALTER TABLE `repo_provincia` DISABLE KEYS */;
INSERT INTO `repo_provincia` VALUES ('Salta','A'),('Buenos Aires (Provincia)','B'),('Ciudad Autónoma de Buenos Aires','C'),('San Luis','D'),('Entre Ríos','E'),('La Rioja','F'),('Santiago del Estero','G'),('Chaco','H'),('San Juan','J'),('Catamarca','K'),('La Pampa','L'),('Mendoza','M'),('Misiones','N'),('Formosa','P'),('Neuquén','Q'),('Rio negro','R'),('Santa Fe','S'),('Tucumán','T'),('Chubut','U'),('Tierra del Fuego','V'),('Corrientes','W'),('Córdoba','X'),('Jujuy','Y'),('Santa Cruz','Z');
/*!40000 ALTER TABLE `repo_provincia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repo_tipo_documento`
--

DROP TABLE IF EXISTS `repo_tipo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repo_tipo_documento` (
  `tipo_documento` char(3) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`tipo_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Codificacion utilizada por ANSeS';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repo_tipo_documento`
--

LOCK TABLES `repo_tipo_documento` WRITE;
/*!40000 ALTER TABLE `repo_tipo_documento` DISABLE KEYS */;
INSERT INTO `repo_tipo_documento` VALUES ('CI','Cédula de Identificación'),('DU','Documento Único (DNI)'),('LE','Libreta Enrolamiento'),('PA','Pasaporte');
/*!40000 ALTER TABLE `repo_tipo_documento` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-12 21:42:54
