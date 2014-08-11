<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stocks', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('item_id');
			$table->timestamps();

			$table->unique(array('user_id', 'item_id'));
		});	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dorp('stocks');
	}

}
