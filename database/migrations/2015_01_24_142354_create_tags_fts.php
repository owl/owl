<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Owl\Repositories\Eloquent\Models\Tag;
use Owl\Repositories\Eloquent\Models\TagFts;

class CreateTagsFts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(env('DB_DRIVER') === 'mysql'){
            DB::statement('ALTER TABLE tags MODIFY COLUMN name varchar(255)
                         CHARACTER SET \'utf8mb4\' COLLATE \'utf8mb4_general_ci\'');
            DB::statement('ALTER TABLE tags ADD FULLTEXT INDEX ft_tag (name) /*!50100 WITH PARSER `ngram` */');
		} else {
			DB::statement('CREATE VIRTUAL TABLE tags_fts USING fts3(tag_id, words);');
			$tags = Tag::get();
			foreach ($tags as $tag) {
				$fts = new TagFts;
				$fts->tag_id = $tag->id;
				$fts->words = FtsUtils::toNgram($tag->name);
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
		if(env('DB_DRIVER') === 'mysql'){
			DB::statement('ALTER TABLE tags MODIFY COLUMN name varchar(255)
                             CHARACTER SET \'utf8mb4\' COLLATE \'utf8mb4_unicode_ci\'');
			DB::statement('ALTER TABLE tags DROP INDEX ft_tag');
		} else {
			DB::statement('DROP TABLE tags_fts ;');
		}
	}

}
