<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('cfb_users')->delete();
		User::create(array(
			'nombre'     => 'Administrador CFB',
			'username'   => 'cfb_admin',
			//'email'    => 'chris@scotch.io',
			'password'   => Hash::make('ce-efe-be'),
		));
	}

}