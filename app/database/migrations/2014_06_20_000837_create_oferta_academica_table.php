<?php

use Illuminate\Database\Migrations\Migration;

class CreateOfertaformativaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso', function($table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->year('anio', 4);
            $table->boolean('permite_inscripciones');
            $table->boolean('vigente');
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('curso');
    }

}