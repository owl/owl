<?php
class SignUpController extends BaseController {
    public function __construct(){
    }

    /*
     * 新規会員登録：入力画面
     */
    public function signup(){
        if (Sentry::check()) {
            return Redirect::to('/');
        }
        return View::make('signup/index');
    }

    /*
     * 新規会員登録：登録処理
     */
    public function register(){
        // バリデーションルールの作成
        $valid_rule = array(
            'username' => 'required|alpha_num|reserved_word|max:30|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|alpha_num|min:4'
        );

        // バリデーション実行
        $validator = Validator::make(Input::all(), $valid_rule);

        // 失敗の場合
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // 成功の場合
        try {
            // ユーザーの作成
            $user = Sentry::createUser(array(
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'activated' => 1,
                'permissions' => array(
                    'user' => 1,
                ),
            ));
            $userGroup = Sentry::findGroupById(2);
            $user->addGroup($userGroup);
            return Redirect::to('login')->with('status', '登録が完了しました。');

        }catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'ユーザ名とパスワードを入力してください。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'パスワードを入力してください。'))
                ->withInput();
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'このログインユーザーは存在します。'))
                ->withInput();
        }
    }
}
