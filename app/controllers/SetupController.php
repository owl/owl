<?php
class SetupController extends BaseController {
    public function getIndex(){
        return View::make('setup/index');
    }

    public function getSentryInit(){
        try{
            $group = Sentry::getGroupProvider()->create(array(
                'name' => 'Administrators',
                'permissions' => array(
                    'admin' => 1,
                    'user' => 1,
                ),
            ));
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            echo 'Administratorグループは既に存在しています。';
        }

        try {
            // Moderatorグループの作成
            $group = Sentry::getGroupProvider()->create(array(
                'name' => 'Moderators',
                'permissions' => array(
                    'admin.view' => 1,
                    'user.create' => 1,
                    'user.delete' => 0,
                    'user.view' => 1,
                    'user.update' => 1,
                ),
            ));
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            echo 'Moderatorsグループは既に存在しています。';
        }

        try {
            // Userグループの作成
            $group = Sentry::getGroupProvider()->create(array(
                'name' => 'Users',
                'permissions' => array(
                    'admin' => 0,
                    'user.create' => 1,
                    'user.delete' => 0,
                    'user.view' => 1,
                    'user.update' => 1,
                ),
            ));
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            echo 'Usersグループは既に存在しています。';
        }

        try {
            // ユーザーの作成
            $user = Sentry::getUserProvider()->create(array(
                'email' => 'winroad@gmail.com',
                'password' => 'winroad',
                'activated' => 1,
            ));
            //グループIDを使用してグループを検索
            $adminGroup = Sentry::getGroupProvider()->findById(1);
            // ユーザーにadminグループを割り当てる
            $user->addGroup($adminGroup);
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            echo 'このログインユーザーは存在します。';
        }
    }
}
