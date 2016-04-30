<?php namespace Owl\Services;

/**
 * @copyright (c) owl
 */

use Owl\Repositories\LoginTokenRepositoryInterface;
use Owl\Repositories\UserRepositoryInterface;
use Owl\Services\UserService;
use Carbon\Carbon;

/**
 * Class AuthService
 */
class AuthService extends Service
{
    /** @var LoginTokenRepositoryInterface */
    protected $loginTokenRepo;

    /** @var UserRepositoryInterface */
    protected $userRepo;

    /** @var UserService */
    protected $userService;

    /**
     * AuthService constructor.
     *
     * @param LoginTokenRepositoryInterface  $loginTokenRepo
     * @param UserRepositoryInterface        $userRepo
     * @param UserService                    $userService
     */
    public function __construct(
        LoginTokenRepositoryInterface $loginTokenRepo,
        UserRepositoryInterface       $userRepo,
        UserService                   $userService
    ) {
        $this->loginTokenRepo = $loginTokenRepo;
        $this->userRepo       = $userRepo;
        $this->userService    = $userService;
    }

    /*
     * ログイン情報を使ってログインを試行する
     *
     * @param array  $credentials  ログイン情報（username, password）
     * @param bool   $remember
     *
     * @return array
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        // パスワードのチェック
        if ($this->checkPassword($credentials['username'], $credentials['password'])) {
            $user_db = $this->userService->getByUsername($credentials['username']);
            $this->login($user_db, $remember);
            return true;
        }
        return false;
    }

    /*
     * 認証済みのユーザー情報を使ってログイン処理を行う
     *
     * @param object  $user  ユーザー情報（id, username, email, password）
     * @param bool    $remember
     *
     * @return array
     */
    public function login($user, $remember = false)
    {
        $this->setUser($user);
        if ($remember) {
            $this->setRememberToken($user->id);
        }
    }

    /*
     * ログインユーザーの情報をセッションに保存する
     *
     * @param Object  $user ユーザー情報
     */
    public function setUser($user)
    {
        // Userのセッションを削除
        \Session::forget("User");

        // ログインに成功したのでセッションIDを再生成
        \Session::regenerate();

        $object = app('stdClass');
        $object->id = $user->id;
        $object->username = $user->username;
        $object->email = $user->email;
        $object->role = $user->role;

        // ログインユーザーの情報を保存
        \Session::push('User', $object);
        \Session::save();
    }

    /*
     * ログインユーザーの情報をセッションから削除する
     */
    public function unsetUser()
    {
        if (\Session::has("User")) {
            \Session::forget("User");
            \Session::save();
        }
    }

    /*
     * オートログインのチェックを行う
     */
    public function autoLoginCheck()
    {
        $token = \Request::cookie('remember_token');
        if ($user = $this->userService->getByToken($token)) {
            $this->deleteOldRememberToken($token);
            $remember = true;
            $this->login($user, $remember);
            return true;
        }
        return false;
    }

    /*
     * RememberTokenをセットする
     */
    public function setRememberToken($userId)
    {
        // Tokenの生成
        $TOKEN_LENGTH = 16; //16*2=32桁
        $token = bin2hex(openssl_random_pseudo_bytes($TOKEN_LENGTH));

        // TokenをDBに登録
        $object = app('stdClass');
        $object->token = $token;
        $object->user_id = $userId;
        $this->loginTokenRepo->createLoginToken($object);

        // TokenをCookieに登録
        $TWO_WEEKS = 14;
        $limit = Carbon::now()->addDays($TWO_WEEKS);
        \Cookie::queue('remember_token', $token, $limit->diffInMinutes(Carbon::now()));
    }

    /*
     * 古くなったRememberTokenをDBから削除する
     */
    public function deleteOldRememberToken($token)
    {
        $this->loginTokenRepo->deleteLoginTokenByToken($token);
    }

    /*
     * RememberTokenCookieを削除する
     */
    public function deleteRememberTokenCookie()
    {
        \Cookie::queue('remember_token', '', -1);
    }

    /*
     * 指定されたユーザーのパスワードが、渡されたパスワードと等しいかチェックする
     *
     * @param string  $username
     * @param string  $password
     *
     * @return bool
     */
    public function checkPassword($username, $password)
    {
        // DBからハッシュされているパスワードを取得
        $user_db = $this->userService->getByUsername($username);
        if (!isset($user_db->id)) {
            return false; // そんな名前のユーザーはいません
        }

        if (password_verify($password, $user_db->password)) {
            return true;
        }

        return false;
    }

    /*
     * パスワードを再設定する
     *
     * @param string  $username
     * @param string  $password
     *
     * @return bool
     */
    public function attemptResetPassword($username, $password)
    {
        $newPassword = password_hash($password, PASSWORD_DEFAULT);

        $result = $this->userRepo->update(['password' => $newPassword], compact('username'));

        return (bool) $result;
    }

    /**
     * @return string
     */
    public function createReminderToken()
    {
        $TOKEN_LENGTH = 16; //16*2=32桁
        $token = bin2hex(openssl_random_pseudo_bytes($TOKEN_LENGTH));

        return $token;
    }
}
