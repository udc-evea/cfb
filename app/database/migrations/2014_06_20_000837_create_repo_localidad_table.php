<?php

use Illuminate\Database\Migrations\Migration;

class CreateRepolocalidadTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repo_localidad', function($table) {
            $table->increments('id');
            $table->char('codigo_provincia', 1)->index();
            $table->string('localidad', 100);
            $table->string('codigoPostal', 10);
            $table->string('codigoTelArea', 5);
            $table->decimal('latitud', 17, 14);
            $table->decimal('longitud', 17, 14);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repo_localidad');
    }

}