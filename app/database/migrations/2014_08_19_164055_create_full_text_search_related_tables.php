<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFullTextSearchRelatedTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        DB::statement('CREATE VIRTUAL TABLE items_fts USING fts4(item_id, words);');
        $items = Item::get();
        foreach($items as $item){
            $fts = new ItemFts;
            $fts->item_id = $item->id;
            $fts->words = NGram::convert($item->title . "\n\n" . $item->body);
            $fts->save();
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::statement('DROP TABLE items_fts ;');
	}

}
