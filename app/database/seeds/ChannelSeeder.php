<?php

class ChannelSeeder extends Seeder
{

	public function run()
	{
		DB::table('channels')->truncate();

		$channel = Channel::create(array(
			'channel_id' => 'TF000000',
			'name'     => 'Talk Focus Sdn Bhd',
			'brand_id' => '1',
			'type'    => 'HQ',
			'address1' => 'No. 36, Level 1 Jalan Tago 9',
			'address2'	=> 'Taman Perindustrian Tago',
			'post_code' => '52200',
			'state' => 'Wilayah Persekutuan',
			'contact' => 'Joyce Yap',
			'phone1' => '0362749233',
			'fax' => '0362749227',
			'created_by' => '1',
			'updated_by' => '1'
		));	
	}

}