<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Owl\Repositories\Tag;
use Owl\Repositories\TagFts;

class CreateTagsFts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement('CREATE VIRTUAL TABLE tags_fts USING fts3(tag_id, words);');
        $tags = Tag::get();
        foreach($tags as $tag){
            $fts = new TagFts;
            $fts->tag_id = $tag->id;
            $fts->words = FtsUtils::toNgram($tag->name);
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
        DB::statement('DROP TABLE tags_fts ;');
	}

}
