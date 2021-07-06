<?php

class BrandSeeder extends Seeder
{

	public function run()
	{
		DB::table('brands')->truncate();
		
		$group = Brand::create(array(
			'name'     => 'HDLS',
			'channel_id' => 'TF000000',
			'created_by' => '1',
			'updated_by' => '1'	
		));

		$group = Brand::create(array(
			'name'     => 'Rewards Mobile',
			'channel_id' => 'TF000503',
			'created_by' => '1',
			'updated_by' => '1'			
		));

		$group = Brand::create(array(
			'name'     => 'XiddiG',
			'channel_id' => 'TF000954',
			'created_by' => '1',
			'updated_by' => '1'			
		));

		$group = Brand::create(array(
			'name'     => 'COOPFon',
			'channel_id' => 'TF000955',
			'created_by' => '1',
			'updated_by' => '1'						
		));

	}

}