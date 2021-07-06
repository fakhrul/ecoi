<?php

class GlossarySeeder extends BaseSeeder
{


	protected $table;


	protected $filename;

		

	public function __construct()
	{
		DB::table('glossary')->truncate();
		$this->table = 'glossary'; // Your database table name
		$this->filename = app_path().'/database/csv/glossary.csv'; // Filename and location of data in csv file
	}

	public function run()
	{
		DB::table($this->table)->truncate();
		$seedData = $this->seedFromCSV($this->filename, ',');
		DB::table($this->table)->insert($seedData);


	}	

}