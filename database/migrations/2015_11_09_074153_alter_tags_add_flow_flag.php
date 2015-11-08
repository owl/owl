<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTagsAddFlowFlag extends Migration {

    const FLOW_FLAG_ON = 1;
    const FLOW_FLAG_OFF = 0;

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('tags', function($table)
        {
            $table->tinyInteger('flow_flag')->after('name')->default(self::FLOW_FLAG_OFF);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('tags', function($table)
        {
            $table->dropColumn('flow_flag');
        });
	}

}
