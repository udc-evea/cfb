SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `cfb`.`inscripcion_carrera` 
DROP FOREIGN KEY `fk_inscripcion_carrera_categoria_ocupacional2`,
DROP FOREIGN KEY `fk_inscripcion_carrera_categoria_ocupacional3`,
DROP FOREIGN KEY `fk_inscripcion_carrera_rama_actividad_laboral1`,
DROP FOREIGN KEY `fk_inscripcion_carrera_repo_nivel_estudios1`,
DROP FOREIGN KEY `fk_inscripcion_carrera_repo_nivel_estudios2`;

ALTER TABLE `cfb`.`inscripcion_carrera` 
CHANGE COLUMN `padre_estudios_id` `padre_estudios_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `padre_categoria_ocupacional_id` `padre_categoria_ocupacional_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `padre_labor` `padre_labor` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `madre_estudios_id` `madre_estudios_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `madre_categoria_ocupacional_id` `madre_categoria_ocupacional_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `madre_labor` `madre_labor` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `padre_ocupacion` `padre_ocupacion` ENUM('PERMANENTE', 'TEMPORARIA') NULL DEFAULT NULL ,
CHANGE COLUMN `madre_ocupacion` `madre_ocupacion` ENUM('PERMANENTE', 'TEMPORARIA') NULL DEFAULT NULL ,
CHANGE COLUMN `situacion_laboral_rama_id` `situacion_laboral_rama_id` INT(10) UNSIGNED NULL DEFAULT NULL ;

ALTER TABLE `cfb`.`inscripcion_carrera` 
ADD CONSTRAINT `fk_inscripcion_carrera_categoria_ocupacional2`
  FOREIGN KEY (`padre_categoria_ocupacional_id`)
  REFERENCES `cfb`.`categoria_ocupacional` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_inscripcion_carrera_categoria_ocupacional3`
  FOREIGN KEY (`madre_categoria_ocupacional_id`)
  REFERENCES `cfb`.`categoria_ocupacional` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_inscripcion_carrera_rama_actividad_laboral1`
  FOREIGN KEY (`situacion_laboral_rama_id`)
  REFERENCES `cfb`.`rama_actividad_laboral` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_inscripcion_carrera_repo_nivel_estudios1`
  FOREIGN KEY (`padre_estudios_id`)
  REFERENCES `cfb`.`repo_nivel_estudios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_inscripcion_carrera_repo_nivel_estudios2`
  FOREIGN KEY (`madre_estudios_id`)
  REFERENCES `cfb`.`repo_nivel_estudios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
