<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('item_id');
            $table->text('body');
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
		Schema::drop('comments');
	}

}
