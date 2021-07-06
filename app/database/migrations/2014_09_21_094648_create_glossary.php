<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlossary extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('glossary', function(Blueprint $table)
		{

			$table->increments('id');
            $table->string('type',50);
            $table->string('value',20);   
			$table->string('label',100);
			$table->string('remarks',100)->default('');
           
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('glossary');
	}

}
