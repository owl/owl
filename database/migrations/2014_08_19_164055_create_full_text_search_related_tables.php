<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Owl\Repositories\Eloquent\Models\Item;
use Owl\Repositories\Eloquent\Models\ItemFts;

class CreateFullTextSearchRelatedTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (env('DB_DRIVER') === 'mysql') {
			DB::statement('ALTER TABLE items MODIFY COLUMN title varchar(255)
                             CHARACTER SET \'utf8mb4\' COLLATE \'utf8mb4_general_ci\'');
			DB::statement('ALTER TABLE items MODIFY COLUMN body text
                             CHARACTER SET \'utf8mb4\' COLLATE \'utf8mb4_general_ci\'');
			DB::statement('ALTER TABLE items ADD FULLTEXT INDEX ft_item (title, body) /*!50100 WITH PARSER `ngram` */');
		} else {
			DB::statement('CREATE VIRTUAL TABLE items_fts USING fts3(item_id, words);');
			$items = Item::get();
			foreach($items as $item){
				$fts = new ItemFts;
				$fts->item_id = $item->id;
				$fts->words = FtsUtils::toNgram($item->title . "\n\n" . $item->body);
				$fts->save();
			}
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (env('DB_DRIVER') === 'mysql') {
			DB::statement('ALTER TABLE items DROP INDEX ft_item');
			DB::statement('ALTER TABLE items MODIFY COLUMN title varchar(255)
                             CHARACTER SET \'utf8mb4\' COLLATE \'utf8mb4_unicode_ci\'');
			DB::statement('ALTER TABLE items MODIFY COLUMN body text
                             CHARACTER SET \'utf8mb4\' COLLATE \'utf8mb4_unicode_ci\'');
		} else {
			DB::statement('DROP TABLE items_fts ;');
		}
	}

}
