<?php

class NewChannelSeeder extends BaseSeeder
{


	protected $table;


	protected $filename;

		
	public function __construct()
	{
		//DB::table('channels')->truncate();
		//DB::table('branch')->truncate();
		//DB::table('branch_user')->truncate();
		$this->table = 'channels'; // Your database table name
		$this->filename = app_path().'/database/csv/channels2.csv'; // Filename and location of data in csv file
	}

	public function run()
	{
		//DB::table($this->table)->truncate();
		$seedData = $this->seedFromCSV($this->filename, ',');
		DB::table($this->table)->insert($seedData);


		/*$channels = Channel::where('id','>',732);

		foreach($channels as $key => $value) {

			echo $value->channel_id;

			$user = new User;
			$user->name       	= $value->channel_id;
			$user->username     = $value->channel_id;
			$user->email 		= $value->email;
			$user->password 	= Hash::make($value->channel_id);
			$user->channel_id	= $value->id;		
			$user->created_by	= '2';
			$user->updated_by	= '2';				
			$user->save();		

			$user->groups()->attach(3);			


			$branch = new Branch;
			$branch->name       	= 'Branch 1';
			$branch->type      		= 'Branch';
			$branch->desc 			= $value->name;
			$branch->channel_id 	= $value->id;	
			$branch->created_by	 	= $user->id;				
			$branch->save();

			$user->branches()->attach($branch->id);

		}*/
	}	

}