SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema cfb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `cfb` ;
CREATE SCHEMA IF NOT EXISTS `cfb` DEFAULT CHARACTER SET latin1 ;
USE `cfb` ;

-- -----------------------------------------------------
-- Table `cfb`.`cfb_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`cfb_users` ;

CREATE TABLE IF NOT EXISTS `cfb`.`cfb_users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username` (`username` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `cfb`.`inscripcion_como_te_enteraste`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`inscripcion_como_te_enteraste` ;

CREATE TABLE IF NOT EXISTS `cfb`.`inscripcion_como_te_enteraste` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `cfb`.`tipo_oferta_formativa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`tipo_oferta_formativa` ;

CREATE TABLE IF NOT EXISTS `cfb`.`tipo_oferta_formativa` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(80) NOT NULL,
  `icono` VARCHAR(50) NOT NULL DEFAULT 'fa-graduation-cap',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cfb`.`oferta_formativa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`oferta_formativa` ;

CREATE TABLE IF NOT EXISTS `cfb`.`oferta_formativa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `anio` YEAR NOT NULL,
  `permite_inscripciones` TINYINT(1) NOT NULL,
  `inicio` DATE NULL DEFAULT NULL,
  `fin` DATE NULL DEFAULT NULL,
  `terminos` TEXT NULL DEFAULT NULL,
  `cupo_maximo` INT UNSIGNED NOT NULL DEFAULT 0,
  `tiene_preinscripcion` TINYINT(1) NOT NULL DEFAULT 0,
  `mail_bienvenida_file_name` VARCHAR(255) NULL DEFAULT NULL,
  `mail_bienvenida_file_size` INT(11) NULL DEFAULT NULL,
  `mail_bienvenida_content_type` VARCHAR(255) NULL DEFAULT NULL,
  `mail_bienvenida_updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tipo_oferta` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_oferta_formativa_tipo_oferta_formativa1_idx` (`tipo_oferta` ASC),
  CONSTRAINT `fk_oferta_formativa_tipo_oferta_formativa1`
    FOREIGN KEY (`tipo_oferta`)
    REFERENCES `cfb`.`tipo_oferta_formativa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `cfb`.`repo_localidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`repo_localidad` ;

CREATE TABLE IF NOT EXISTS `cfb`.`repo_localidad` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `localidad` VARCHAR(100) NOT NULL,
  `codigoPostal` VARCHAR(10) NULL,
  `codigoTelArea` VARCHAR(5) NULL,
  `latitud` DECIMAL(17,14) NULL,
  `longitud` DECIMAL(17,14) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 87
DEFAULT CHARACTER SET = latin1
COMMENT = 'Localidades de Argentina';


-- -----------------------------------------------------
-- Table `cfb`.`repo_nivel_estudios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`repo_nivel_estudios` ;

CREATE TABLE IF NOT EXISTS `cfb`.`repo_nivel_estudios` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nivel_estudios` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `cfb`.`inscripcion_oferta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`inscripcion_oferta` ;

CREATE TABLE IF NOT EXISTS `cfb`.`inscripcion_oferta` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oferta_formativa_id` INT(10) UNSIGNED NOT NULL,
  `tipo_documento_cod` CHAR(3) NOT NULL,
  `estado_inscripcion` INT UNSIGNED NOT NULL DEFAULT 1,
  `documento` INT(10) UNSIGNED NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `localidad_id` INT(10) UNSIGNED NOT NULL,
  `localidad_otra` VARCHAR(100) NULL DEFAULT NULL,
  `localidad_anios_residencia` INT UNSIGNED NOT NULL,
  `nivel_estudios_id` INT(10) UNSIGNED NOT NULL,
  `titulo_obtenido` VARCHAR(200) NULL DEFAULT NULL,
  `email` VARCHAR(80) NOT NULL,
  `telefono` VARCHAR(50) NOT NULL,
  `como_te_enteraste` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `oferta_academica_id_2` (`oferta_formativa_id` ASC, `tipo_documento_cod` ASC, `documento` ASC),
  UNIQUE INDEX `oferta_academica_id_3` (`oferta_formativa_id` ASC, `email` ASC),
  INDEX `tipo_documento_cod` (`tipo_documento_cod` ASC),
  INDEX `localidad_id` (`localidad_id` ASC),
  INDEX `documento` (`documento` ASC),
  INDEX `apellido` (`apellido` ASC, `nombre` ASC),
  INDEX `nivel_estudios_id` (`nivel_estudios_id` ASC),
  INDEX `oferta_academica_id` (`oferta_formativa_id` ASC),
  INDEX `fk_inscripcion_persona_inscripcion_como_te_enteraste1_idx` (`como_te_enteraste` ASC),
  CONSTRAINT `fk_inscripcion_persona_oferta_academica1`
    FOREIGN KEY (`oferta_formativa_id`)
    REFERENCES `cfb`.`oferta_formativa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `inscripcion_persona_ibfk_2`
    FOREIGN KEY (`localidad_id`)
    REFERENCES `cfb`.`repo_localidad` (`id`),
  CONSTRAINT `inscripcion_persona_ibfk_3`
    FOREIGN KEY (`nivel_estudios_id`)
    REFERENCES `cfb`.`repo_nivel_estudios` (`id`),
  CONSTRAINT `fk_inscripcion_persona_inscripcion_como_te_enteraste1`
    FOREIGN KEY (`como_te_enteraste`)
    REFERENCES `cfb`.`inscripcion_como_te_enteraste` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 426
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `cfb`.`repo_provincia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`repo_provincia` ;

CREATE TABLE IF NOT EXISTS `cfb`.`repo_provincia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `provincia` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Provincias Argentinas';


-- -----------------------------------------------------
-- Table `cfb`.`repo_tipo_documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`repo_tipo_documento` ;

CREATE TABLE IF NOT EXISTS `cfb`.`repo_tipo_documento` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Codificacion utilizada por ANSeS';


-- -----------------------------------------------------
-- Table `cfb`.`oferta_requisitos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`oferta_requisitos` ;

CREATE TABLE IF NOT EXISTS `cfb`.`oferta_requisitos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `oferta_id` INT UNSIGNED NOT NULL,
  `requisito` VARCHAR(200) NOT NULL,
  `obligatorio` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_oferta_requisitos_oferta_academicaa` (`oferta_id` ASC),
  CONSTRAINT `fk_oferta_requisitos_oferta_academicaa`
    FOREIGN KEY (`oferta_id`)
    REFERENCES `cfb`.`oferta_formativa` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cfb`.`inscripcion_requisito_presentado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`inscripcion_requisito_presentado` ;

CREATE TABLE IF NOT EXISTS `cfb`.`inscripcion_requisito_presentado` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `requisito_id` INT UNSIGNED NOT NULL,
  `inscripto_id` INT UNSIGNED NOT NULL,
  `inscripto_type` VARCHAR(100) NOT NULL,
  `fecha_presentacion` DATE NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_inscripcion_requisito_presentado_oferta_requisitos1_idx` (`requisito_id` ASC),
  INDEX `inscripcion_id` (`inscripto_id` ASC),
  INDEX `requisito_id` (`requisito_id` ASC),
  CONSTRAINT `fk_inscripcion_requisito_presentado_oferta_requisitos1`
    FOREIGN KEY (`requisito_id`)
    REFERENCES `cfb`.`oferta_requisitos` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cfb`.`repo_pais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`repo_pais` ;

CREATE TABLE IF NOT EXISTS `cfb`.`repo_pais` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cfb`.`nacionalidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`nacionalidad` ;

CREATE TABLE IF NOT EXISTS `cfb`.`nacionalidad` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cfb`.`categoria_ocupacional`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`categoria_ocupacional` ;

CREATE TABLE IF NOT EXISTS `cfb`.`categoria_ocupacional` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cfb`.`con_quien_vive`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`con_quien_vive` ;

CREATE TABLE IF NOT EXISTS `cfb`.`con_quien_vive` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cfb`.`rama_actividad_laboral`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`rama_actividad_laboral` ;

CREATE TABLE IF NOT EXISTS `cfb`.`rama_actividad_laboral` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cfb`.`inscripcion_carrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cfb`.`inscripcion_carrera` ;

CREATE TABLE IF NOT EXISTS `cfb`.`inscripcion_carrera` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oferta_formativa_id` INT(10) UNSIGNED NOT NULL,
  `tipo_documento_cod` INT UNSIGNED NOT NULL,
  `estado_inscripcion` INT UNSIGNED NOT NULL DEFAULT 1,
  `documento` INT(10) UNSIGNED NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `nacionalidad_id` INT UNSIGNED NOT NULL,
  `localidad_id` INT(10) UNSIGNED NOT NULL,
  `localidad_otra` VARCHAR(100) NULL DEFAULT NULL,
  `localidad_depto` VARCHAR(80) NOT NULL DEFAULT 'RAWSON',
  `localidad_pcia` INT UNSIGNED NOT NULL,
  `localidad_pais` INT UNSIGNED NOT NULL,
  `domicilio_procedencia_tipo` ENUM('CASA', 'DEPTO', 'PENSION', 'RESIDENCIA') NOT NULL,
  `domicilio_procedencia_calle` VARCHAR(200) NULL,
  `domicilio_procedencia_nro` INT UNSIGNED NOT NULL DEFAULT 0,
  `domicilio_procedencia_piso` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `domicilio_procedencia_depto` VARCHAR(5) NOT NULL DEFAULT '-',
  `domicilio_procedencia_localidad_id` INT UNSIGNED NOT NULL,
  `domicilio_procedencia_localidad_otra` VARCHAR(100) NULL,
  `domicilio_procedencia_cp` VARCHAR(10) NOT NULL,
  `domicilio_procedencia_pais_id` INT UNSIGNED NOT NULL,
  `domicilio_procedencia_telefono_fijo` VARCHAR(50) NOT NULL,
  `domicilio_procedencia_telefono_celular` VARCHAR(45) NOT NULL,
  `domicilio_procedencia_email` VARCHAR(100) NOT NULL,
  `domicilio_clases_tipo` ENUM('CASA', 'DEPTO', 'PENSION', 'RESIDENCIA') NOT NULL,
  `domicilio_clases_calle` VARCHAR(200) NULL,
  `domicilio_clases_localidad_id` INT UNSIGNED NOT NULL,
  `domicilio_clases_pais_id` INT UNSIGNED NOT NULL,
  `situacion_laboral` ENUM('TRABAJA', 'NO TRABAJA', 'DESOCUPADO') NOT NULL,
  `situacion_laboral_ocupacion` ENUM('TEMPORAL','PERMANENTE') NOT NULL,
  `situacion_laboral_relacion_trabajo_carrera` ENUM('TOTAL','PARCIAL','NINGUNA') NOT NULL,
  `situacion_laboral_categoria_ocupacional_id` INT UNSIGNED NOT NULL,
  `situacion_laboral_detalle_labor` TEXT NOT NULL,
  `padre_apeynom` VARCHAR(255) NOT NULL,
  `padre_vive` ENUM('SI','NO','NS/NC') NOT NULL,
  `padre_estudios_id` INT UNSIGNED NOT NULL,
  `padre_categoria_ocupacional_id` INT UNSIGNED NOT NULL,
  `padre_labor` TEXT NOT NULL,
  `madre_apeynom` VARCHAR(255) NOT NULL,
  `madre_vive` ENUM('SI','NO','NS/NC') NOT NULL,
  `madre_estudios_id` INT UNSIGNED NOT NULL,
  `madre_categoria_ocupacional_id` INT UNSIGNED NOT NULL,
  `madre_labor` TEXT NOT NULL,
  `domicilio_clases_nro` INT UNSIGNED NOT NULL DEFAULT 0,
  `domicilio_clases_piso` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `domicilio_clases_depto` VARCHAR(5) NOT NULL DEFAULT '-',
  `domicilio_clases_localidad_otra` VARCHAR(100) NULL,
  `domicilio_clases_cp` VARCHAR(10) NOT NULL,
  `domicilio_clases_telefono` VARCHAR(50) NOT NULL,
  `domicilio_clases_email` VARCHAR(100) NOT NULL,
  `domicilio_clases_con_quien_vive_id` INT UNSIGNED NOT NULL,
  `secundario_titulo_obtenido` VARCHAR(200) NOT NULL,
  `secundario_anio_egreso` YEAR NOT NULL,
  `secundario_nombre_colegio` VARCHAR(255) NOT NULL,
  `secundario_localidad_colegio` INT UNSIGNED NOT NULL,
  `secundario_localidad_colegio_otra` VARCHAR(100) NULL,
  `secundario_pcia` INT UNSIGNED NOT NULL,
  `secundario_pais` INT UNSIGNED NOT NULL,
  `secundario_tipo_establecimiento` ENUM('ESTATAL', 'PRIVADO') NOT NULL,
  `situacion_laboral_horas_semana` TINYINT(1) UNSIGNED NOT NULL,
  `padre_ocupacion` ENUM('PERMANENTE', 'TEMPORARIA') NOT NULL,
  `madre_ocupacion` ENUM('PERMANENTE', 'TEMPORARIA') NOT NULL,
  `situacion_laboral_rama_id` INT UNSIGNED NOT NULL,
  `inscripcion_carrera_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `oferta_academica_id_2` (`oferta_formativa_id` ASC, `tipo_documento_cod` ASC, `documento` ASC),
  INDEX `tipo_documento_cod` (`tipo_documento_cod` ASC),
  INDEX `documento` (`documento` ASC),
  INDEX `apellido` (`apellido` ASC, `nombre` ASC),
  INDEX `oferta_academica_id` (`oferta_formativa_id` ASC),
  INDEX `fk_inscripcion_carrera_nacionalidad1_idx` (`nacionalidad_id` ASC),
  INDEX `fk_inscripcion_carrera_repo_localidad1_idx` (`localidad_id` ASC),
  INDEX `fk_inscripcion_carrera_repo_provincia1_idx` (`localidad_pcia` ASC),
  INDEX `fk_inscripcion_carrera_repo_pais1_idx` (`localidad_pais` ASC),
  INDEX `fk_inscripcion_carrera_repo_localidad2_idx` (`domicilio_procedencia_localidad_id` ASC),
  INDEX `fk_inscripcion_carrera_repo_pais2_idx` (`domicilio_procedencia_pais_id` ASC),
  INDEX `fk_inscripcion_carrera_repo_localidad3_idx` (`domicilio_clases_localidad_id` ASC),
  INDEX `fk_inscripcion_carrera_repo_pais3_idx` (`domicilio_clases_pais_id` ASC),
  INDEX `fk_inscripcion_carrera_categoria_ocupacional1_idx` (`situacion_laboral_categoria_ocupacional_id` ASC),
  INDEX `fk_inscripcion_carrera_categoria_ocupacional2_idx` (`padre_categoria_ocupacional_id` ASC),
  INDEX `fk_inscripcion_carrera_categoria_ocupacional3_idx` (`madre_categoria_ocupacional_id` ASC),
  INDEX `fk_inscripcion_carrera_repo_localidad4_idx` (`secundario_localidad_colegio` ASC),
  INDEX `fk_inscripcion_carrera_repo_provincia2_idx` (`secundario_pcia` ASC),
  INDEX `fk_inscripcion_carrera_repo_pais4_idx` (`secundario_pais` ASC),
  INDEX `fk_inscripcion_carrera_con_quien_vive1_idx` (`domicilio_clases_con_quien_vive_id` ASC),
  INDEX `fk_inscripcion_carrera_rama_actividad_laboral1_idx` (`situacion_laboral_rama_id` ASC),
  INDEX `fk_inscripcion_carrera_repo_nivel_estudios1_idx` (`padre_estudios_id` ASC),
  INDEX `fk_inscripcion_carrera_repo_nivel_estudios2_idx` (`madre_estudios_id` ASC),
  INDEX `fk_inscripcion_carrera_inscripcion_carrera1_idx` (`inscripcion_carrera_id` ASC),
  CONSTRAINT `fk_inscripcion_carrera_nacionalidad1`
    FOREIGN KEY (`nacionalidad_id`)
    REFERENCES `cfb`.`nacionalidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_localidad1`
    FOREIGN KEY (`localidad_id`)
    REFERENCES `cfb`.`repo_localidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_provincia1`
    FOREIGN KEY (`localidad_pcia`)
    REFERENCES `cfb`.`repo_provincia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_pais1`
    FOREIGN KEY (`localidad_pais`)
    REFERENCES `cfb`.`repo_pais` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_localidad2`
    FOREIGN KEY (`domicilio_procedencia_localidad_id`)
    REFERENCES `cfb`.`repo_localidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_pais2`
    FOREIGN KEY (`domicilio_procedencia_pais_id`)
    REFERENCES `cfb`.`repo_pais` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_localidad3`
    FOREIGN KEY (`domicilio_clases_localidad_id`)
    REFERENCES `cfb`.`repo_localidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_pais3`
    FOREIGN KEY (`domicilio_clases_pais_id`)
    REFERENCES `cfb`.`repo_pais` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_categoria_ocupacional1`
    FOREIGN KEY (`situacion_laboral_categoria_ocupacional_id`)
    REFERENCES `cfb`.`categoria_ocupacional` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_categoria_ocupacional2`
    FOREIGN KEY (`padre_categoria_ocupacional_id`)
    REFERENCES `cfb`.`categoria_ocupacional` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_categoria_ocupacional3`
    FOREIGN KEY (`madre_categoria_ocupacional_id`)
    REFERENCES `cfb`.`categoria_ocupacional` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_localidad4`
    FOREIGN KEY (`secundario_localidad_colegio`)
    REFERENCES `cfb`.`repo_localidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_provincia2`
    FOREIGN KEY (`secundario_pcia`)
    REFERENCES `cfb`.`repo_provincia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_pais4`
    FOREIGN KEY (`secundario_pais`)
    REFERENCES `cfb`.`repo_pais` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_con_quien_vive1`
    FOREIGN KEY (`domicilio_clases_con_quien_vive_id`)
    REFERENCES `cfb`.`con_quien_vive` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_rama_actividad_laboral1`
    FOREIGN KEY (`situacion_laboral_rama_id`)
    REFERENCES `cfb`.`rama_actividad_laboral` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_nivel_estudios1`
    FOREIGN KEY (`padre_estudios_id`)
    REFERENCES `cfb`.`repo_nivel_estudios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_nivel_estudios2`
    FOREIGN KEY (`madre_estudios_id`)
    REFERENCES `cfb`.`repo_nivel_estudios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_repo_tipo_documento1`
    FOREIGN KEY (`tipo_documento_cod`)
    REFERENCES `cfb`.`repo_tipo_documento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_oferta_formativa1`
    FOREIGN KEY (`oferta_formativa_id`)
    REFERENCES `cfb`.`oferta_formativa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_carrera_inscripcion_carrera1`
    FOREIGN KEY (`inscripcion_carrera_id`)
    REFERENCES `cfb`.`inscripcion_carrera` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 426
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `cfb`.`inscripcion_como_te_enteraste`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`inscripcion_como_te_enteraste` (`id`, `descripcion`) VALUES (NULL, 'Diarios');
INSERT INTO `cfb`.`inscripcion_como_te_enteraste` (`id`, `descripcion`) VALUES (NULL, 'Radio');
INSERT INTO `cfb`.`inscripcion_como_te_enteraste` (`id`, `descripcion`) VALUES (NULL, 'TV');
INSERT INTO `cfb`.`inscripcion_como_te_enteraste` (`id`, `descripcion`) VALUES (NULL, 'Visita en las escuelas');
INSERT INTO `cfb`.`inscripcion_como_te_enteraste` (`id`, `descripcion`) VALUES (NULL, 'Web institucional');
INSERT INTO `cfb`.`inscripcion_como_te_enteraste` (`id`, `descripcion`) VALUES (NULL, 'Otro');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`tipo_oferta_formativa`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`tipo_oferta_formativa` (`id`, `descripcion`, `icono`) VALUES (NULL, 'Carrera Presencial', 'fa-university');
INSERT INTO `cfb`.`tipo_oferta_formativa` (`id`, `descripcion`, `icono`) VALUES (NULL, 'Curso/Taller', 'fa-graduation-cap');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`oferta_formativa`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`oferta_formativa` (`id`, `nombre`, `anio`, `permite_inscripciones`, `inicio`, `fin`, `terminos`, `cupo_maximo`, `tiene_preinscripcion`, `mail_bienvenida_file_name`, `mail_bienvenida_file_size`, `mail_bienvenida_content_type`, `mail_bienvenida_updated_at`, `tipo_oferta`) VALUES (NULL, 'Curso de prueba', 2014, 1, '2014-10-10', '2014-11-10', NULL, 0, 0, NULL, NULL, NULL, NULL, 2);
INSERT INTO `cfb`.`oferta_formativa` (`id`, `nombre`, `anio`, `permite_inscripciones`, `inicio`, `fin`, `terminos`, `cupo_maximo`, `tiene_preinscripcion`, `mail_bienvenida_file_name`, `mail_bienvenida_file_size`, `mail_bienvenida_content_type`, `mail_bienvenida_updated_at`, `tipo_oferta`) VALUES (NULL, 'Software', 2015, 1, '2015-03-20', '2015-12-05', NULL, 0, 1, NULL, NULL, NULL, NULL, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`repo_localidad`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`repo_localidad` (`id`, `localidad`, `codigoPostal`, `codigoTelArea`, `latitud`, `longitud`) VALUES (NULL, 'Rawson', NULL, NULL, NULL, NULL);
INSERT INTO `cfb`.`repo_localidad` (`id`, `localidad`, `codigoPostal`, `codigoTelArea`, `latitud`, `longitud`) VALUES (NULL, 'Trelew', NULL, NULL, NULL, NULL);
INSERT INTO `cfb`.`repo_localidad` (`id`, `localidad`, `codigoPostal`, `codigoTelArea`, `latitud`, `longitud`) VALUES (NULL, 'Gaiman', NULL, NULL, NULL, NULL);
INSERT INTO `cfb`.`repo_localidad` (`id`, `localidad`, `codigoPostal`, `codigoTelArea`, `latitud`, `longitud`) VALUES (NULL, 'Puerto Madryn', NULL, NULL, NULL, NULL);
INSERT INTO `cfb`.`repo_localidad` (`id`, `localidad`, `codigoPostal`, `codigoTelArea`, `latitud`, `longitud`) VALUES (99, 'Otra', NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`repo_nivel_estudios`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'Sin estudios');
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'NS/NC');
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'Primario incompleto');
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'Primario completo');
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'Secundario incompleto');
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'Secundario completo');
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'Terciario');
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'Universitario incompleto');
INSERT INTO `cfb`.`repo_nivel_estudios` (`id`, `nivel_estudios`) VALUES (NULL, 'Universitario completo');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`repo_provincia`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`repo_provincia` (`id`, `provincia`) VALUES (NULL, 'Chubut');
INSERT INTO `cfb`.`repo_provincia` (`id`, `provincia`) VALUES (NULL, 'Santa Cruz');
INSERT INTO `cfb`.`repo_provincia` (`id`, `provincia`) VALUES (NULL, 'Córdoba');
INSERT INTO `cfb`.`repo_provincia` (`id`, `provincia`) VALUES (NULL, 'Buenos Aires');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`repo_tipo_documento`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`repo_tipo_documento` (`id`, `descripcion`) VALUES (NULL, 'DNI');
INSERT INTO `cfb`.`repo_tipo_documento` (`id`, `descripcion`) VALUES (NULL, 'LC');
INSERT INTO `cfb`.`repo_tipo_documento` (`id`, `descripcion`) VALUES (NULL, 'LE');
INSERT INTO `cfb`.`repo_tipo_documento` (`id`, `descripcion`) VALUES (NULL, 'Pasaporte');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`repo_pais`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`repo_pais` (`id`, `nombre`) VALUES (NULL, 'Argentina');
INSERT INTO `cfb`.`repo_pais` (`id`, `nombre`) VALUES (NULL, 'Chile');
INSERT INTO `cfb`.`repo_pais` (`id`, `nombre`) VALUES (NULL, 'Colombia');
INSERT INTO `cfb`.`repo_pais` (`id`, `nombre`) VALUES (NULL, 'Bolivia');
INSERT INTO `cfb`.`repo_pais` (`id`, `nombre`) VALUES (NULL, 'Perú');
INSERT INTO `cfb`.`repo_pais` (`id`, `nombre`) VALUES (NULL, 'Cuba');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`nacionalidad`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`nacionalidad` (`id`, `descripcion`) VALUES (NULL, 'Argentino/a');
INSERT INTO `cfb`.`nacionalidad` (`id`, `descripcion`) VALUES (NULL, 'Argentino/a Naturalizado/a');
INSERT INTO `cfb`.`nacionalidad` (`id`, `descripcion`) VALUES (NULL, 'Extranjero/a');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`categoria_ocupacional`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`categoria_ocupacional` (`id`, `categoria`) VALUES (NULL, 'Obrero/Empleado');
INSERT INTO `cfb`.`categoria_ocupacional` (`id`, `categoria`) VALUES (NULL, 'Patrón');
INSERT INTO `cfb`.`categoria_ocupacional` (`id`, `categoria`) VALUES (NULL, 'Cuenta Propia');
INSERT INTO `cfb`.`categoria_ocupacional` (`id`, `categoria`) VALUES (NULL, 'Jubilado/Pensionado');
INSERT INTO `cfb`.`categoria_ocupacional` (`id`, `categoria`) VALUES (NULL, 'Ama de Casa');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`con_quien_vive`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`con_quien_vive` (`id`, `descripcion`) VALUES (NULL, 'Solo');
INSERT INTO `cfb`.`con_quien_vive` (`id`, `descripcion`) VALUES (NULL, 'Padres y hermanos');
INSERT INTO `cfb`.`con_quien_vive` (`id`, `descripcion`) VALUES (NULL, 'Residencia Universitaria');
INSERT INTO `cfb`.`con_quien_vive` (`id`, `descripcion`) VALUES (NULL, 'Con compañeros');
INSERT INTO `cfb`.`con_quien_vive` (`id`, `descripcion`) VALUES (NULL, 'Cónyuge e hijos');

COMMIT;


-- -----------------------------------------------------
-- Data for table `cfb`.`rama_actividad_laboral`
-- -----------------------------------------------------
START TRANSACTION;
USE `cfb`;
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Agricultura, Ganaderia o Minería');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Industria y Construcción');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Comercio may. y Minor.');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Bancos, Bolsas, Seguros y Soc. Financ.');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Enseñanza');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Entes Civiles del Estado');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Fuerzas Armadas y de Seguridad');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Ejercicio de Profesión Liberal');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Serv. Públicos y Privados Part.');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Inst. Deportivas y Afines');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Artes en gral. y Afines');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Medios de Comunicación');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Ocupaciones varias');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Hogares Privados c/ Servicio Doméstico');
INSERT INTO `cfb`.`rama_actividad_laboral` (`id`, `descripcion`) VALUES (NULL, 'Otros');

COMMIT;

