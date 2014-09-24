<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->call('TipoDocumentosTableSeeder');
		$this->call('CursosTableSeeder');
		$this->call('LocalidadsTableSeeder');
		$this->call('RequisitosTableSeeder');
	}

}
