<?php namespace Owl\Services;

use Owl\Models\User;

class UserService extends Service
{
    /*
     * ユーザーの作成
     *
     * @param array ユーザー情報（username, email, password）
     * @return array
     */
    public function createUser(array $credentials = [])
    {
        $user = new User;
        $user->fill(array(
            'username' => $credentials['username'],
            'email' => $credentials['email'],
            'password' => password_hash($credentials['password'], PASSWORD_DEFAULT)
        ));
        $user->save();

        return $user;
    }

    /*
     * ログインユーザーの情報を取得する
     *
     * @return array
     */
    public function getCurrentUser()
    {
        if (\Session::has('User')) {
            $user = \Session::get('User');
            return $user[0];
        }

        return false;
    }

    /*
     * IDを使ってユーザー情報を取得する
     *
     * @return array
     */
    public function getUserById($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            return $user;
        }
        return false;
    }
}
