<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('branch', function ($table) {

            $table->increments('id');
            $table->string('name', 50);
            $table->string('channel_id', 20);		
            $table->string('type', 10);
            $table->string('desc', 250);     
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
					           
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();					
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('branch');
	}

}
