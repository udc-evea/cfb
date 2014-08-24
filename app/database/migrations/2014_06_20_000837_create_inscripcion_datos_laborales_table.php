<?php

use Illuminate\Database\Migrations\Migration;

class CreateInscripciondatoslaboralesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_datos_laborales', function($table) {
            $table->increments('id');
            $table->integer('inscripcion_id')->unsigned()->primary();
            $table->string('trabajo_lugar', 50)->nullable();
            $table->string('trabajo_antiguedad', 45)->nullable();
            $table->string('trabajo_condicion', 45)->nullable();
            $table->string('trabajo_descripcion', 45)->nullable();
            $table->string('trabajo_anterior_lugar', 50)->nullable();
            $table->string('trabajo_anterior_descripcion', 45)->nullable();
            $table->string('trabajo_anterior_antiguedad', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inscripcion_datos_laborales');
    }

}