<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrepaidOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prepaid_order', function ($table) {

            $table->increments('id');
            $table->string('msisdn', 20);
            $table->string('iccid', 20);

            $table->string('name', 80);
            $table->string('id_type',20);
			$table->string('ic',80);

			$table->string('race',20);
			$table->string('nation',20);

			$table->string('gender',20);
			$table->date('birth_date');
			$table->string('marital_status',20);			
			$table->string('language',50);

			$table->string('reg_no_type',20);
			$table->string('reg_no',50);
			$table->string('mycard_type',10);

			$table->string('address1',100);
			$table->string('address2',100);
			$table->string('address3',100);
			$table->string('post_code',20);	
			$table->string('city',100);
			$table->string('state',100);
			$table->string('country',100);			

			$table->string('email',250)->nullable();
			$table->string('alternate_no',15)->nullable();
			$table->string('member_no',20)->nullable();
			$table->string('referral_no',20)->nullable();
			$table->string('receipt_no',20)->nullable();	

			$table->integer('status')->default('1');
			$table->integer('brand_id');			
			$table->integer('channel_id');
			$table->integer('branch_id');
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
        Schema::drop('prepaid_order');
	}

}
