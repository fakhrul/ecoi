<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsisdn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('msisdn', function ($table) {
 
            $table->increments('id');
            $table->string('msisdn', 15);
            $table->string('iccid', 20);
            $table->integer('package_id', false);             
            $table->integer('scheme_id', false);
            $table->integer('brand_id', false);              
            $table->integer('status', false)->default('1');
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
        Schema::drop('msisdn');
	}

}
