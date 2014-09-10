## Centro de Formación Bimodal

Proyecto para el CFB de la Universidad del Chubut, hecho con [Laravel](http://laravel.com).

### Instalación

## Pre-requisitos:

# PHP 5.5+
# [Composer](http://getcomposer.org).
# git


````bash
# clonar el repositorio
git clone https://github.com/udc-evea/cfb.git

# instalar dependencias
cd cfb
composer install

# crear configuración para el entorno local a partir de la plantilla
# el archivo debe llamarse '.env.local.php'
cp env.local_sample.php .env.local.php

# otorgar permisos de escritura al servidor web (Apache) en directorios de trabajo
# (www-data suele ser el usuario con el que se ejecuta)
sudo chmod -R 775 app/storage
sudo chgrp -R www-data app/storage

# instalar la base de ejemplo
mysql -u root -p  < app/database/base.sql

````
