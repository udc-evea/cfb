<?php

use Illuminate\Database\Migrations\Migration;

class CreateRepopersonaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repo_persona', function($table) {
            $table->increments('id');
            $table->char('tipo_documento_cod', 3)->index();
            $table->integer('documento')->unsigned()->index();
            $table->string('apellido', 100)->index();
            $table->string('nombre', 100);
            $table->char('sexo', 1);
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('localidad_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repo_persona');
    }

}