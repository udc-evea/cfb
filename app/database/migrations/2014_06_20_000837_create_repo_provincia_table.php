<?php

use Illuminate\Database\Migrations\Migration;

class CreateRepoprovinciaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repo_provincia', function($table) {
            $table->increments('id');
            $table->string('provincia', 255);
            $table->char('id', 1)->primary();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repo_provincia');
    }

}