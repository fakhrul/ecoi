<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseSeeder extends Seeder
{

	//Collect data from a given CSV file and return as array

	public function seedFromCSV($filename, $deliminator = ",")
	{
		if(!file_exists($filename) || !is_readable($filename))
		{
			return FALSE;
		}

		ini_set('auto_detect_line_endings', true);
		$header = NULL;
		$data = array();

		if(($handle = fopen($filename, 'r')) !== FALSE)
		{
			while(($row = fgetcsv($handle, 1000, $deliminator)) !== FALSE)
			{

				if(!$header) {
					$header = $row;
					//var_dump($header);
				} else {
					$data[] = array_combine($header, $row);
					//var_dump($header);
				}
			
			}
			fclose($handle);
		}

		return $data;
	}
}