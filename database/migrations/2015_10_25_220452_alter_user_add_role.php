<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserAddRole extends Migration {

    const ROLE_ID_MEMBER = 1;
    const ROLE_ID_OWNER = 2;

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        Schema::table('users', function($table)
        {
            $table->string('role')->default(self::ROLE_ID_MEMBER);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table)
        {
            $table->dropColumn('role');
        });
	}

}
