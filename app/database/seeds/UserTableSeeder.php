<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('users')->truncate();
		DB::table('brand_user')->truncate();	
		DB::table('acl_user_groups')->truncate();				

		$user = User::create(array(
			'name'     => 'Nazer',
			'username' => 'nazer',
			'email'    => 'nazer@hdls.com.my',
			'password' => Hash::make('ilovehdls'),
			'created_by'=> '1',
			'updated_by'=> '1'
		));

		$user->groups()->attach(1);	

		$ids = Brand::all()->lists('id');
		$user->brands()->sync($ids);

		$user = User::create(array(
			'name'     => 'Joyce Yap',
			'username' => 'joyce.yap',
			'email'    => 'joyce.yap@hdls.com.my',
			'password' => Hash::make('ilovehdls'),
			'created_by'=> '1',
			'updated_by'=> '1'
		));		

		$user->groups()->attach(2);		

		$user->brands()->attach(1);			
	}

}