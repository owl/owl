<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterItemTableAddedOpenItemId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('items', function($t) {
            $t->string('open_item_id', 20)->default($this->tempid())->after('id');
        });
        $items = Item::all();
        foreach($items as $item){
            $item->open_item_id = $this->tempid();
            $item->timestamps = false;
            $item->save();
        }
	}

    private function tempid(){
        return substr(md5(uniqid()),0,20);
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('items', function($t) {
            $t->dropColumn('open_item_id');
        });
	}

}
