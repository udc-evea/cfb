<?php

use Illuminate\Database\Migrations\Migration;

class CreateInscripcionpersonaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_persona', function($table) {
            $table->increments('id');
            $table->integer('persona_id')->unsigned();
            $table->integer('curso_id')->unsigned()->index();
            $table->char('tipo_documento_cod', 3)->index();
            $table->integer('documento')->unsigned()->index();
            $table->string('apellido', 100)->index();
            $table->string('nombre', 100);
            $table->char('sexo', 1);
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('localidad_id')->nullable()->unsigned()->index();
            $table->string('localidad_otra', 100)->nullable();
            $table->integer('localidad_anios_residencia')->unsigned();
            $table->integer('nivel_estudios_id')->unsigned()->index();
            $table->string('email', 80)->unique();
            $table->string('telefono', 50);
            $table->string('titulo_obtenido', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inscripcion_persona');
    }

}