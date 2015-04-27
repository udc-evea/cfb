<?php

class UserTableSeeder extends Seeder
{

	public function run(){
		DB::table('cfb_users')->delete();
		User::create(array(
			'nombreyapellido'   =>  'Centro de Formacion Bimodal',
			'username'   => 'cfb',
			//'email'    => 'chris@scotch.io',
			'password'   => Hash::make('cfb'),
		));
	}

}
