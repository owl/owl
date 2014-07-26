<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserAdmin extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $user = Sentry::createUser(array(
            'username' => 'admin',
            'email' => 'admin@athena.example',
            'password' => 'password',
            'activated' => 1,
            'permissions' => array(
                'superuser' => 1,
            ),
        ));
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        User::where('username','=','admin')->firstOrFail()->delete();
	}

}
