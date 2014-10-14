<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMailBienvenidaFieldsToOfertaFormativaTable extends Migration {

	/**
	 * Make changes to the table.
	 *
	 * @return void
	 */
	public function up()
	{	
		Schema::table('oferta_formativa', function(Blueprint $table) {		
			
			$table->string('mail_bienvenida_file_name')->nullable();
			$table->integer('mail_bienvenida_file_size')->nullable();
			$table->string('mail_bienvenida_content_type')->nullable();
			$table->timestamp('mail_bienvenida_updated_at')->nullable();

		});

	}

	/**
	 * Revert the changes to the table.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('oferta_formativa', function(Blueprint $table) {

			$table->dropColumn('mail_bienvenida_file_name');
			$table->dropColumn('mail_bienvenida_file_size');
			$table->dropColumn('mail_bienvenida_content_type');
			$table->dropColumn('mail_bienvenida_updated_at');

		});
	}

}
