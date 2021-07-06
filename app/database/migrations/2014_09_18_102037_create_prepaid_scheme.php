<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrepaidScheme extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('prepaid_scheme', function ($table) {
 
            $table->increments('id');
            $table->string('name', 50);
            $table->string('desc', 255)->nullable();
 			$table->timestamps();
 				  
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('prepaid_scheme');
	}

}
