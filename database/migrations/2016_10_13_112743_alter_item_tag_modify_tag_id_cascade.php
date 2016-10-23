<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterItemTagModifyTagIdCascade extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_tag', function($table)
        {
            $table->dropForeign('item_tag_item_id_foreign');
            $table->dropForeign('item_tag_tag_id_foreign');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_tag', function($table)
        {
            $table->dropForeign('item_tag_item_id_foreign');
            $table->dropForeign('item_tag_tag_id_foreign');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

}
