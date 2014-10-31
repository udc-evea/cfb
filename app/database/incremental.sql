SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `cfb`.`inscripcion_carrera` 
CHANGE COLUMN `situacion_laboral_ocupacion` `situacion_laboral_ocupacion` ENUM('TEMPORAL','PERMANENTE') NULL DEFAULT NULL ,
CHANGE COLUMN `situacion_laboral_relacion_trabajo_carrera` `situacion_laboral_relacion_trabajo_carrera` ENUM('TOTAL','PARCIAL','NINGUNA') NULL DEFAULT NULL ,
CHANGE COLUMN `situacion_laboral_categoria_ocupacional_id` `situacion_laboral_categoria_ocupacional_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `situacion_laboral_detalle_labor` `situacion_laboral_detalle_labor` TEXT NULL DEFAULT NULL 
;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
-- ----------------------------------------------------- ----------------------------------------------------- ----------------------------------------------
