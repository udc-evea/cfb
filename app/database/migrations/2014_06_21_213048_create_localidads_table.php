<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocalidadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Localidads', function(Blueprint $table) {
			$table->increments('id');
			$table->int('codigo_provincia');
			$table->string('localidad');
			$table->string('codigoPostal');
			$table->string('codigoTelArea');
			$table->double('latitud');
			$table->double('longitud');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Localidads');
	}

}
