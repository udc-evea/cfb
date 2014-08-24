<?php

use Illuminate\Database\Migrations\Migration;

class CreateReponivelestudiosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repo_nivel_estudios', function($table) {
            $table->increments('id');
            $table->string('nivel_estudios', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repo_nivel_estudios');
    }

}