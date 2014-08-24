<?php

use Illuminate\Database\Migrations\Migration;

class CreateInscripcionencuestaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_encuesta', function($table) {
            $table->increments('id');
            $table->integer('inscripcion_id')->unsigned()->primary();
            $table->text('encuesta_1');
            $table->text('encuesta_2');
            $table->text('encuesta_3');
            $table->text('encuesta_4');
            $table->text('encuesta_5');
            $table->text('encuesta_6');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inscripcion_encuesta');
    }

}