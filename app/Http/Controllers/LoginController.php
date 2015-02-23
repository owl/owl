<?php namespace Owl\Http\Controllers;

class LoginController extends Controller {

    public function __construct(){
    }

    // ログインフォームの表示
    public function login(){
        if (Sentry::check()) {
            return Redirect::to('/');
        }
        return View::make('login/index');
    }

    public function auth(){
        try {
            // フォームからemailとpaswordの連想配列を取得
            $login = Input::only('username','password');
            $user = Sentry::authenticate($login, Input::get('remember'));
            return Redirect::to('/'); 
        }catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'ユーザ名とパスワードを入力してください。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'パスワードを入力してください。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'アクティベートされていません。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'ログイン試行上限に達しました。15分間はログインできません。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'ユーザ名又はパスワードが正しくありません'))
                ->withInput();
        }
    }
}
