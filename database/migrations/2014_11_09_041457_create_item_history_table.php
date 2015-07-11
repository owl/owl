<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Owl\Repositories\Eloquent\Models\Item;
use Owl\Repositories\Eloquent\Models\ItemHistory;

class CreateItemHistoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('items_history',function($table)
        {
            $table->increments('id');
            $table->integer('item_id');
            $table->string('open_item_id',20);
            $table->integer('user_id');
            $table->string('title',255);
            $table->text('body');
            $table->integer('published')->default(0);
            $table->timestamps();
        });

        $items = Item::all();
        foreach( $items as $item ){
            $this->createPastHistory($item);
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('items_history');
    }

    public function createPastHistory($item)
    {
        $his = ItemHistory::newInstance();
        $his->item_id = $item->id;
        $his->user_id = $item->user_id;
        $his->open_item_id = $item->open_item_id;
        $his->title = $item->title;
        $his->body = $item->body;
        $his->published = $item->published;
        $his->created_at = $item->created_at;
        $his->updated_at = $item->updated_at;
        $his->save();

        return $his;
    }
}
