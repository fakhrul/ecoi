<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('channels',function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('channel_id',20)->unique();
			$table->string('name',255);
			$table->string('reg_no',45);
			$table->string('brand_id',10);			
			$table->string('type',50);
			$table->integer('upline_id')->nullable();
			$table->date('effective_date')->nullable();			
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('address3')->nullable();
			$table->string('post_code',10)->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('contact')->nullable();
			$table->string('phone1',50)->nullable();
			$table->string('phone2',50)->nullable();
			$table->string('fax',20)->nullable();
			$table->string('email',100)->nullable();
			$table->string('bank_name',50)->nullable();
			$table->string('bank_no',20)->nullable();
			$table->string('remarks',500)->nullable();


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
		Schema::drop('channels');
	}

}
