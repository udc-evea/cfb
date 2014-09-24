SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `cfb`.`oferta_requisitos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oferta_id` INT(10) UNSIGNED NOT NULL,
  `requisito` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_oferta_requisitos_oferta_academica1`
    FOREIGN KEY (`oferta_id`)
    REFERENCES `cfb`.`oferta_academica` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE TABLE IF NOT EXISTS `cfb`.`inscripcion_requisito_presentado` (
  `inscripcion_id` INT(10) UNSIGNED NOT NULL,
  `requisito_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`inscripcion_id`, `requisito_id`),
  INDEX `fk_inscripcion_requisito_presentado_oferta_requisitos1_idx` (`requisito_id` ASC),
  CONSTRAINT `fk_inscripcion_requisito_presentado_inscripcion_persona1`
    FOREIGN KEY (`inscripcion_id`)
    REFERENCES `cfb`.`inscripcion_persona` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_requisito_presentado_oferta_requisitos1`
    FOREIGN KEY (`requisito_id`)
    REFERENCES `cfb`.`oferta_requisitos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

DROP TABLE IF EXISTS `cfb`.`inscripcion_encuesta` ;

DROP TABLE IF EXISTS `cfb`.`inscripcion_datos_laborales` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
