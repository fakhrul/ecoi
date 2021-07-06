<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrepaidOrderReq extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('prepaid_order_req', function ($table) {
 
            $table->increments('id');
            $table->integer('prepaid_order_id', false);
            $table->integer('order_id')->nullable();    
            $table->string('req', 3000);
            $table->string('status', 50)->default('N');  
            $table->string('message', 300)->nullable();        
 			$table->timestamps();
 			  
        });

        Schema::table('prepaid_order', function($table) {
                $table->integer('order_id')->nullable();
                $table->string('order_type',20)->index();
        });        
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('prepaid_order_req');

        Schema::table('prepaid_order', function($table) {
                $table->dropColumn('order_id');
                $table->dropColumn('order_type');
       });           
	}

}
