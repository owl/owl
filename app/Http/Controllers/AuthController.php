<?php namespace Owl\Http\Controllers;

use Owl\Services\AuthService;
use Owl\Services\UserService;
use Owl\Http\Requests\AuthAttemptRequest;

class AuthController extends Controller
{
    protected $authService;
    protected $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /*
     * ログイン画面
     */
    public function login()
    {
        return view('login.index');
    }

    /*
     * ログイン認証
     */
    public function attempt(AuthAttemptRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if ($this->authService->attempt($credentials, $request->has('remember'))) {
            return \Redirect::to('/');
        } else {
            return \Redirect::back()
                ->withErrors(array('warning' => 'ユーザ名又はパスワードが正しくありません'))
                ->withInput();
        }
    }

    /*
     * ログアウト処理
     */
    public function logout()
    {
        $this->authService->unsetUser();
        $token = \Request::cookie('remember_token');
        if ($token) {
            $this->authService->deleteOldRememberToken($token);
            $this->authService->deleteRememberTokenCookie();
        }
        return \Redirect::to('login');
    }
}
