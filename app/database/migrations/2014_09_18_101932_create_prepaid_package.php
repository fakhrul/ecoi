<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrepaidPackage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('prepaid_package', function ($table) {
 
            $table->increments('id');
            $table->string('name', 50);
            $table->string('desc', 255)->nullable();
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
        Schema::drop('prepaid_package');
	}

}
