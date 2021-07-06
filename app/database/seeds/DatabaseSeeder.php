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



		$this->call('PermissionSeeder');		

		$this->call('GroupSeeder');	

		//$this->call('BrandSeeder');		

		//$this->call('UserTableSeeder');		

		//$this->call('NewChannelSeeder');


		//$this->call('GlossarySeeder');



	}

}