<?php
class LoginController extends BaseController {
    protected static $loginAttribute = 'email';

    // ログインフォームの表示
    public function getIndex(){
        return View::make('login/index');
    }

    public function postIndex(){
        try {
            // フォームからemailとpaswordの連想配列を取得
            $login = Input::only('email','password');
            $user = Sentry::authenticate($login, Input::get('remember'));
            return Redirect::to('/'); 
        }catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'Emailとパスワードを入力してください。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'パスワードを入力してください。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'アクティベートされていません。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => '該当者がいません。'))
                ->withInput();
        }
    }
}
