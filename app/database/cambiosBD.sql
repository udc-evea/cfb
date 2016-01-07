<?php

/*
 * En este archivo voy guardando los cambios que voy
 * realizando en la BD, con los comandos SQL correspondientes
 * y explicando porque hice los cambios.
 */


/* ######  2015/10/28  ####################### 
//         VERSION 3.0.0
// versión para arrancar la documentación de los cambios
// realizados en la BD.

//Cargar el archivo que se llama "cfb_base_3.0.sql" que se encuentra
//en el directorio: C:\xampp\htdocs\cfb\app\database\cfb_base_3.0.sql
//en él se encuentra la base para luego ir aplicando los cambios de más abajo
*/


/* ######  2015/10/28  ####################### */
--         VERSION 3.0.1
-- agrego el campo "aprobado" en la tabla "inscripcion_oferta" para poder
-- separar a los inscriptos en las comisiones en "aprobados/desaprobados" al final del curso
-- la sintaxis es:
ALTER TABLE `inscripcion_oferta` 
ADD `aprobado` TINYINT 
NOT NULL DEFAULT '0' 
COMMENT 'Campo para almacenar si el alumno aprobó o no' ;


/* ######  2015/10/29  ####################### */
--         VERSION 3.0.2
-- creo la tabla "version_bd" con el campo "version" para ir almacenando en este
-- la versión de la modificación actual, para poder ir comprobando si falta actualizar 
-- la base o no.
-- la sintaxis es:
CREATE TABLE version_bd (version varchar(10));
INSERT INTO `cfb`.`version_bd` (`version`) VALUES ('3.0.2');


/* ######  2016/01/07  ####################### */
--         VERSION 3.0.3
-- agrego en la tabla "oferta_formativa" los campos USER_ID_MODIF y FECHA_MODIF
-- la sintaxis es:
ALTER TABLE `oferta_formativa` ADD `user_id_modif` INT NOT NULL COMMENT 'ID del usuario que realizó la ultima modificación a la oferta' ;
ALTER TABLE `oferta_formativa` ADD `fecha_modif` DATE NOT NULL COMMENT 'Fecha de la última modificación realizada a la oferta' ;
UPDATE  `cfb`.`version_bd` SET  `version` =  '3.0.3' WHERE  `version_bd`.`version` =  '3.0.2' LIMIT 1 ;