<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        // Adminグループの作成
        try{
            $group = Sentry::createGroup(array(
                'name' => 'Administrators',
                'permissions' => array(
                    'admin' => 1,
                    'user' => 1,
                ),
            ));
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            echo 'Administratorグループは既に存在しています。';
        }

        // Userグループの作成
        try {
            $group = Sentry::createGroup(array(
                'name' => 'Users',
                'permissions' => array(
                    'admin' => 0,
                    'user' => 1,
                ),
            ));
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            echo 'Usersグループは既に存在しています。';
        }

        try {
            // ユーザーの作成
            $user = Sentry::createUser(array(
                'username' => 'admin',
                'email' => 'admin@athena.example',
                'password' => 'password',
                'activated' => 1,
                'permissions' => array(
                    'superuser' => 1,
                ),
            ));
            //グループIDを使用してグループを検索
            $adminGroup = Sentry::findGroupById(1);
            // ユーザーにadminグループを割り当てる
            $user->addGroup($adminGroup);
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            echo 'このログインユーザーは存在します。';
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        User::where('username','=','admin')->firstOrFail()->delete();

        $userGroup = Sentry::findGroupById(2);
        $userGroup->delete();

        $adminGroup = Sentry::findGroupById(1);
        $adminGroup->delete();

	}

}
