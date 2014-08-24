<?php

use Illuminate\Database\Migrations\Migration;

class CreateRepotipodocumentoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_documento', function($table) {
            $table->increments('id');
            $table->char('tipo_documento', 3)->primary();
            $table->string('descripcion', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipo_documento');
    }

}