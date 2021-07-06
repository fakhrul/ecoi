<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrepaidAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prepaid_account', function ($table) {

            $table->increments('id');
            $table->string('msisdn', 20);
            $table->string('name', 255);
			$table->integer('status')->default(1);
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
        Schema::drop('prepaid_account');
	}

}
