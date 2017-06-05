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


/* ######  2016/02/22  ####################### */
--         VERSION 3.0.4
-- agrego en la tabla "inscripcion_evento" el campo "ASISTENTE"
-- la sintaxis es:
ALTER TABLE `inscripcion_evento` ADD `asistente` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Campo donde se guarda aquellos ASISTENTES al evento (con un 1)' ;
UPDATE  `cfb`.`version_bd` SET  `version` =  '3.0.4' WHERE  `version_bd`.`version` =  '3.0.3' LIMIT 1 ;


/* ######  2016/03/04  ####################### */
--         VERSION 3.1.0
-- Agrego cambios para la funcionalidad de los certificados
-- la sintaxis es:
/* creo el campo resolucion_nro */
-> ALTER TABLE `oferta_formativa` ADD `resolucion_nro` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Es el Nro. de Resolución interna con la cuál se aprueba la creación de esta Oferta' ;
/* creo el campo lugar */
-> ALTER TABLE `oferta_formativa` ADD `lugar` VARCHAR(100) NOT NULL COMMENT 'Lugar en donde se desarrollará la Oferta' ;
/* creo el campo duracion_hs */
-> ALTER TABLE `oferta_formativa` ADD `duracion_hs` INT UNSIGNED NULL DEFAULT '0' COMMENT 'La cantidad de horas reloj que involucra la Oferta.' ;
/* creo el campo lleva_tit_previa */
-> ALTER TABLE `oferta_formativa` ADD `lleva_tit_previa` TINYINT NOT NULL DEFAULT '0' COMMENT 'La Oferta necesita una titulación previa para inscribirse?' ;
/* creo la tabla TITULACION con sus campos y propiedades */
-> CREATE TABLE titulacion (
`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'PK de la tabla TITULACION.',
`nombre_titulacion` VARCHAR(50) COMMENT 'Es el nombre de la TITULACION.',
`abreviatura_titulacion` VARCHAR(10) COMMENT 'Es la abreviación de la titulación.',
PRIMARY KEY (`id`)
)DEFAULT CHARSET='utf8';
/* agrego el registro con ID=1 (Titulacion: Ninguna, Abreviacion: " ") */
-> INSERT INTO `cfb`.`titulacion` (`id`, `nombre_titulacion`, `abreviatura_titulacion`) VALUES (1, 'Ninguna', '');
/* creo el campo titulacion_id */
-> ALTER TABLE `oferta_formativa` ADD `titulacion_id` INT(11) NULL DEFAULT NULL COMMENT 'Es la titulación del inscripto, correspondiente a la tabla de TITULACIONES.';
/* agrego el FK del campo 'oferta_formativa'.titulacion_id' a 'titulacion'.'id_titulacion' */
-> ALTER TABLE `oferta_formativa` ADD  CONSTRAINT `fk_of_form-tit_id-titulacion` FOREIGN KEY (`titulacion_id`) REFERENCES `cfb`.`titulacion`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
/* agrego a la tabla 'inscripcion_carrera' el campo para guardar el codigo de verificacion para el Certificado */
-> ALTER TABLE `inscripcion_carrera` ADD `codigo_verificacion` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Campo dónde se almacenará el código de verificación para los Certificados, según el correspondiente caso.' , ADD UNIQUE (`codigo_verificacion`) ;
/* agrego a la tabla 'inscripcion_evento' el campo para guardar el codigo de verificacion para el Certificado */
-> ALTER TABLE `inscripcion_evento` ADD `codigo_verificacion` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Campo dónde se almacenará el código de verificación para los Certificados, según el correspondiente caso.' , ADD UNIQUE (`codigo_verificacion`) ;
/* agrego a la tabla 'inscripcion_oferta' el campo para guardar el codigo de verificacion para el Certificado */
-> ALTER TABLE `inscripcion_oferta` ADD `codigo_verificacion` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Campo dónde se almacenará el código de verificación para los Certificados, según el correspondiente caso.' , ADD UNIQUE (`codigo_verificacion`) ;
/* creo la tabla ROL_CAPACITADOR con sus campos y propiedades */
-> CREATE TABLE rol_capacitador (
`id` INT(10) NOT NULL AUTO_INCREMENT COMMENT 'PK del tipo de Rol posible para el Capacitador.',
`rol` VARCHAR(40) COMMENT 'Descripcion del Rol.',
PRIMARY KEY (`id`)
)DEFAULT CHARSET='utf8';
/* Agrego los valores que pasaron desde la planilla inicial */
-> INSERT INTO `cfb`.`rol_capacitador` (`id`, `rol`) VALUES (1, 'Capacitador'), (2, 'Ayudante'), (3, 'Evaluador'), (4, 'Diseñador');
/* creo la tabla PERSONAL con sus campos y propiedades */
-> CREATE TABLE personal (
`id` INT(10) NOT NULL AUTO_INCREMENT COMMENT 'PK del tipo de la persona habilitada para ser capacitador.',
`apellido` VARCHAR(40) NOT NULL,
`nombre` VARCHAR(40) NOT NULL,
`dni` INT(10) unsigned NOT NULL,
`email` VARCHAR(80) NOT NULL,
`titulacion_id` INT(11) NULL DEFAULT NULL,
PRIMARY KEY (`id`)
)DEFAULT CHARSET='utf8';
/* agrego el FK del campo 'personal'.titulacion_id' a 'titulacion'.'id_titulacion' */
-> ALTER TABLE `personal` ADD  CONSTRAINT `fk_personal-tit_id-titulacion_id` FOREIGN KEY (`titulacion_id`) REFERENCES `cfb`.`titulacion`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
/* ingreso un dato para ir probando la tabla */
-> INSERT INTO `cfb`.`personal` (`id`, `apellido`, `nombre`, `dni`, `email`, `titulacion_id`) VALUES (NULL, 'Martinez', 'Guillermo Andres', '29777888', 'ing.gmart@gmail.com', '2');
/* creo la tabla CAPACITADOR con sus campos y propiedades */
-> CREATE TABLE capacitador (
`id` INT(10) NOT NULL AUTO_INCREMENT COMMENT 'PK del tipo de ROL que puede tener un capacitador en alguna Oferta.',
`oferta_id` INT(10) unsigned NOT NULL,
`personal_id` INT(10) NOT NULL,
`rol_id` INT(10) NOT NULL,
PRIMARY KEY (`id`)
)DEFAULT CHARSET='utf8';
/* agrego el FK del campo 'capacitador'.'oferta_id' a 'oferta_formativa'.'id' */
-> ALTER TABLE `capacitador` ADD  CONSTRAINT `fk_capacitador-of_id-oferta_form_id` FOREIGN KEY (`oferta_id`) REFERENCES `cfb`.`oferta_formativa`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
/* agrego el FK del campo 'capacitador'.'personal_id' a 'personal'.'id_personal' */
-> ALTER TABLE `capacitador` ADD  CONSTRAINT `fk_capacitador-pers_id-personal_id` FOREIGN KEY (`personal_id`) REFERENCES `cfb`.`personal`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
/* agrego el FK del campo 'capacitador'.'rol_id' a 'rol_capacitador'.'id_rol' */
-> ALTER TABLE `capacitador` ADD  CONSTRAINT `fk_capacitador-rol_id-rol_capacitador-id` FOREIGN KEY (`rol_id`) REFERENCES `cfb`.`rol_capacitador`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
/* Cambio en la base la versión del sistema, de 3.0.4 a 3.1.0 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.0' WHERE  `version_bd`.`version` =  '3.0.4' LIMIT 1 ;
/* Esta versión de base de datos corresponde con la versión 3.1.4 de código */


/* ######  2016/03/28  ####################### */
--         VERSION 3.1.1
-- Agrego cambios para la funcionalidad de los certificados
-- la sintaxis es:
/* Agrego indice de restricción para los Capacitadores: Un capacitador no puede tener mas de un rol en una oferta */
ALTER TABLE `capacitador` ADD UNIQUE `unique_capacitador_index`(`oferta_id`, `personal_id`);
/* Esta versión de base de datos corresponde con la versión 3.1.5 de código */


/* ######  2016/03/31  ####################### */
--         VERSION 3.1.1
-- Agrego cambios para la funcionalidad de los certificados
-- la sintaxis es:
/* agrgego campo para los certificados de los alumnos que aprueban la oferta */
-> ALTER TABLE `oferta_formativa` ADD `cert_base_alum_file_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Campo para almacenar el certificado base de los alumnos aprobados de la Oferta' ;
-> ALTER TABLE `oferta_formativa` ADD `cert_base_alum_file_size` INT(11) NULL DEFAULT NULL ;
-> ALTER TABLE `oferta_formativa` ADD `cert_base_alum_content_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
-> ALTER TABLE `oferta_formativa` ADD `cert_base_alum_updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ;
/* agrgego campo para los certificados del/los capacitador/es de la oferta */
-> ALTER TABLE `oferta_formativa` ADD `cert_base_cap_file_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Campo para almacenar el certificado base del/los capacitadores de la Oferta' ;
-> ALTER TABLE `oferta_formativa` ADD `cert_base_cap_file_size` INT(11) NULL DEFAULT NULL ;
-> ALTER TABLE `oferta_formativa` ADD `cert_base_cap_content_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
-> ALTER TABLE `oferta_formativa` ADD `cert_base_cap_updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ;
/* Cambio en la base la versión del sistema, de 3.1.0 a 3.1.1 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.1' WHERE  `version_bd`.`version` =  '3.1.0' LIMIT 1 ;
/* Esta versión de base de datos corresponde con la versión 3.1.6 de código */


/* ######  2016/04/12  ####################### */
--         VERSION 3.1.2
-- Agrego cambios para la funcionalidad de los certificados
-- la sintaxis es:
/* Cambio en la base la versión del sistema, de 3.1.1 a 3.1.2 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.2' WHERE  `version_bd`.`version` =  '3.1.1' LIMIT 1 ;
/* Agrego campo en la tabla "version_bd" para ir guardando la versión del código también */
-> ALTER TABLE `version_bd` ADD `version_codigo` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Campo para guardar la versión del código.' ;
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.6' WHERE  `version_bd`.`version_codigo` =  '3.1.1' LIMIT 1 ;


/* ######  2016/04/28  ####################### */
--    VERSION_BASE: 3.1.3 - VERSION_CODIGO: 3.1.6
-- Cambio el "tipo" del campo "resolucion_nro" de entero a cadena
-- la sintaxis es:
/* Cambio en la base la versión del sistema, de 3.1.2 a 3.1.3 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.3' WHERE  `version_bd`.`version` =  '3.1.2' LIMIT 1 ;
/* Cambio en la base la versión de código del sistema, de 3.1.6 a 3.1.7 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.6' WHERE  `version_bd`.`version_codigo` =  '3.1.1' LIMIT 1 ;
/* Modifico el tipo en el */
-> ALTER TABLE `oferta_formativa` CHANGE `resolucion_nro` `resolucion_nro` VARCHAR(30) NULL DEFAULT NULL COMMENT 'Es el Nro. de Resolución interna con la cuál se aprueba la creación de esta Oferta';


/* ######  2016/05/04  ####################### */
--    VERSION_BASE: 3.1.4 - VERSION_CODIGO: 3.1.7
-- Agrego "fecha_fin_oferta" para que se anote la fecha de fin de cursada para mostrarse en el Certificado (solo para Ofertas y eventos)
-- la sintaxis es:
/* Cambio en la base la versión del sistema, de 3.1.3 a 3.1.4 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.4' WHERE  `version_bd`.`version` =  '3.1.3' LIMIT 1 ;
/* Cambio en la base la versión de código del sistema, de 3.1.7 a 3.1.8 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.8' WHERE  `version_bd`.`version_codigo` =  '3.1.7' LIMIT 1 ;
/* Agrego el campo "fecha_fin_oferta" en la tabla "oferta_formativa" */
-> ALTER TABLE `oferta_formativa` ADD `fecha_fin_oferta` DATE NULL DEFAULT NULL COMMENT 'Fecha de Fin de la Oferta (solo Eventos y Cursos). Se obtiene de la Resolución de creación de Oferta.' AFTER `resolucion_nro`;


/* ######  2016/05/25  ####################### */
--    VERSION_BASE: 3.1.4 - VERSION_CODIGO: 3.1.9
-- Arreglos varios en el código
/* 
1) Arreglo del error de la vista de mail.
2) Arreglo de envío de mail "cupo_exedido" solo para eventos.
3) Separación de preinscriptos e inscriptos en pestañas para carrera
4) Se mantienen los campos de ordenamiento (nro. y apellido.) y búsqueda tanto en la pestaña de preinscriptos como la de inscriptos
5) se cambia la versión del código a 3.1.9
*/
-- la sintaxis es:
/* Cambio en la base la versión de código del sistema, de 3.1.8 a 3.1.9 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.9' WHERE  `version_bd`.`version_codigo` =  '3.1.8' LIMIT 1 ;



/* ######  2016/05/31  ####################### */
--    VERSION_BASE: 3.1.5 - VERSION_CODIGO: 3.1.10
-- Validacion de Certificados
/* 
1) Código de verificacion es con A-Z y 0-9 (sin minusculas)
2) Creo form de verificación con GET+CUV, GET solo y POST
3) Agrego el campo de codigo_verificacion en la tabla "Capacitar", para el certificado.
4) Agrego el codigo_verificacion en la creacion de los Capacitadores y por ende en su Certificados
5) se cambia la versión del código a 3.1.10
6) se cambia la versión de la base de datos a 3.1.5
*/
-- la sintaxis es:
/* creo el campo codigo_verificacion para los capacitadores UNIQUE */
-> ALTER TABLE `capacitador` ADD `codigo_verificacion` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Campo dónde se almacenará el código de verificación para los Certificados de los Capacitadores' , ADD UNIQUE (`codigo_verificacion`) ;
/* Cambio en la base la versión de código del sistema, de 3.1.9 a 3.1.10 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.10' WHERE  `version_bd`.`version_codigo` =  '3.1.9' LIMIT 1 ;
/* Cambio en la base la versión del sistema, de 3.1.4 a 3.1.5 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.5' WHERE  `version_bd`.`version` =  '3.1.4' LIMIT 1 ;


/* ######  2016/06/24  ####################### */
--    VERSION_BASE: 3.1.6 - VERSION_CODIGO: 3.1.11
-- Archivar Oferta (e inscripciones de la Oferta)
/* 
1) se cambia la versión del código a 3.1.11
2) se cambia la versión de la base de datos a 3.1.6
*/
-- la sintaxis es:
/* Cambio en la base la versión de código del sistema, de 3.1.10 a 3.1.11 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.11' WHERE  `version_bd`.`version_codigo` =  '3.1.10' LIMIT 1 ;
/* Cambio en la base la versión del sistema, de 3.1.5 a 3.1.6 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.6' WHERE  `version_bd`.`version` =  '3.1.5' LIMIT 1 ;
/* Agrego campo que determina si la Oferta está FINALIZADA o no */
-> ALTER TABLE `oferta_formativa` ADD `finalizada` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Campo que determina si la Oferta está finalizada o no.' ;


/* ######  2016/07/31  ####################### */
--    VERSION_BASE: 3.1.7 - VERSION_CODIGO: 3.1.12
-- Función notificacion_inscripto (Of/Ca/Ev)
/* 
1) se cambia la versión del código a 3.1.12
2) se cambia la versión de la base de datos a 3.1.7
3) agrego el campo `cant_notificaciones_inscripto` en Of/Ca/Ev
*/
-- la sintaxis es:
/* Cambio en la base la versión de código del sistema, de 3.1.11 a 3.1.12 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.12' WHERE  `version_bd`.`version_codigo` =  '3.1.11' LIMIT 1 ;
/* Cambio en la base la versión del sistema, de 3.1.5 a 3.1.6 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.7' WHERE  `version_bd`.`version` =  '3.1.6' LIMIT 1 ;
/* agrego el campo `cant_notificaciones_inscripto` en Inscripcion_oferta */
-> ALTER TABLE `inscripcion_oferta` ADD `cant_notificaciones_inscripto` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Registro de la cantidad de mail de inscripcion que se le envió al inscripto.' AFTER `cant_notificaciones`;
/* agrego el campo `cant_notificaciones_inscripto` en Inscripcion_evento */
-> ALTER TABLE `inscripcion_evento` ADD `cant_notificaciones_inscripto` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Registro de la cantidad de mail de inscripcion que se le envió al inscripto.' AFTER `cant_notificaciones`;
/* agrego el campo `cant_notificaciones_inscripto` en Inscripcion_carrera */
-> ALTER TABLE `inscripcion_carrera` ADD `cant_notificaciones_inscripto` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Registro de la cantidad de mail de inscripcion que se le envió al inscripto.' AFTER `cant_notificaciones`;


/* ######  2016/08/10  ####################### */
--    VERSION_BASE: 3.1.8 - VERSION_CODIGO: 3.1.15
-- Función envio_certificado_aprobado (Of/Ca/Ev)
/* 
1) se cambia la versión del código a 3.1.15
2) se cambia la versión de la base de datos a 3.1.8
3) agrego el campo `cant_notificaciones_certificado` en Of/Ca/Ev
*/
-- la sintaxis es:
/* Cambio en la base la versión de código del sistema, de 3.1.12 a 3.1.15 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.15' WHERE  `version_bd`.`version_codigo` =  '3.1.12' LIMIT 1 ;
/* Cambio en la base la versión del sistema, de 3.1.6 a 3.1.7 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.8' WHERE  `version_bd`.`version` =  '3.1.7' LIMIT 1 ;
/* agrego el campo `cant_notificaciones_certificado` en Inscripcion_oferta */
-> ALTER TABLE `inscripcion_oferta` ADD `cant_notificaciones_certificado` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Registro de la cantidad de mail con el Certificado que se le envió al aprobado.' AFTER `cant_notificaciones_inscripto`;
/* agrego el campo `cant_notificaciones_inscripto` en Inscripcion_evento */
-> ALTER TABLE `inscripcion_evento` ADD `cant_notificaciones_certificado` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Registro de la cantidad de mail con el Certificado que se le envió al asistente.' AFTER `cant_notificaciones_inscripto`;


/* ######  2016/11/09  ####################### */
--    VERSION_BASE: 3.1.8 - VERSION_CODIGO: 3.1.15
-- Arreglo de bugs + Nuevo rol_capacitador
/* 
1) se mantiene la versión del código en 3.1.15
2) se mantiene la versión de la base de datos en 3.1.8
3) agrego el rol_capacitados en BD "Expositor"
4) Arreglo la vista "Inicio" (no se veia el botón "Personal")
*/
-- la sintaxis es:
/* Agrego el Rol_Capacitador en la Base de datos */
-> INSERT INTO `cfb`.`rol_capacitador` (`id`, `rol`) VALUES (NULL, 'Expositor');



/* ######  2016/11/13  ####################### */
--    VERSION_BASE: 3.1.8 - VERSION_CODIGO: 3.1.15
-- DNI capacitador con letras + envío de certif por mail a capacitador
/* 
1) se mantiene la versión del código en 3.1.15
2) se mantiene la versión de la base de datos en 3.1.8
3) cambio el tipo de campo DNI a text (varchar) para dnis extrajeros
4) agrego envío del certificado del capacitador por mail
*/
-- la sintaxis es:
/* Cambio el tipo de campo en la BD de integer(10) a varchar(10) */
-> ALTER TABLE `personal` CHANGE `dni` `dni` VARCHAR(10) NOT NULL;


/* ######  2017/05/22  ####################### */
--    VERSION_BASE: 3.1.8 - VERSION_CODIGO: 3.1.16
-- Se agrega el sistema de importación de Ofertas/cursos y Alumnos por archivo XLSX
/* 
1) se cambia la versión del código en 3.1.16
2) se mantiene la versión de la base de datos en 3.1.8
3) agrego importar Oferta/Evento mediante archivo XLSX
4) agrego importar alumnos a Oferta/Evento mediante archivo XLSX

/* Cambio en la base la versión de código del sistema, de 3.1.15 a 3.1.16 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.16' WHERE  `version_bd`.`version_codigo` =  '3.1.15' LIMIT 1 ;


/* ######  2017/05/22  ####################### */
--    VERSION_BASE: 3.1.9 - VERSION_CODIGO: 3.1.17
-- Se agrega el sexo del/la capacitador/a (en los certificado tambien)
/* 
1) se cambia la versión del código en 3.1.17
2) se cambia la versión de la base de datos en 3.1.9
3) agrego 1) Hombre 2)Mujer 3)Sin Especficar (por defecto)
4) agrego el campo del sexo en "Personal p/Capacitaciones"
5) cambio los certificados de capacitadores segun el sexo

/* Cambio en la base la versión de código del sistema, de 3.1.16 a 3.1.17 */
-> UPDATE  `cfb`.`version_bd` SET  `version_codigo` =  '3.1.17' WHERE  `version_bd`.`version_codigo` =  '3.1.16' LIMIT 1 ;
/* Cambio en la base la versión del sistema, de 3.1.7 a 3.1.8 */
-> UPDATE  `cfb`.`version_bd` SET  `version` =  '3.1.9' WHERE  `version_bd`.`version` =  '3.1.8' LIMIT 1 ;
/* Creo la Tabla sexo*/
->  CREATE TABLE Sexo (
        id int NOT NULL,
        descripcion varchar(30) NOT NULL UNIQUE,
        CONSTRAINT id_sexo_pk PRIMARY KEY (id)
    );
/* Agrego las filas 1) Hombre - 2) Mujer - 3) Sin Especificar (predeterminado) */
-> INSERT INTO `cfb`.`Sexo` (`id`, `descripcion`) VALUES ('1', 'Hombre');
-> INSERT INTO `cfb`.`Sexo` (`id`, `descripcion`) VALUES ('2', 'Mujer');
-> INSERT INTO `cfb`.`Sexo` (`id`, `descripcion`) VALUES ('3', 'Sin Especificar');
/* Agrego el campo de sexo en el personal para capacitaciones */
-> ALTER TABLE `personal` ADD `sexo_id` INT NOT NULL DEFAULT '3' AFTER `email`;