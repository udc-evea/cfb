## Centro de Formación Bimodal

Proyecto para el CFB de la Universidad del Chubut, hecho con [Laravel](http://laravel.com).

### Instalación

## Pre-requisitos:

1. PHP 5.4+ con extensión [MCrypt](http://stackoverflow.com/a/24233500).
2. [Composer](http://getcomposer.org).
3. git


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

# instalar la base de ejemplo (estructura) y datos simples
mysql -u root -p  < app/database/base.sql

# rellenar (seed) la base con datos iniciales
# (usuario de prueba)
php artisan db:seed

# levantar el servidor de desarrollo
php artisan serve

````
Y hasta este punto, el proyecto debería estar disponible en `http://localhost:8000`.
