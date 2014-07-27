<?php
class SignUpController extends BaseController {
    public function __construct(){
    }

    /*
     * 新規会員登録：入力画面
     */
    public function getIndex(){
        if (Sentry::check()) {
            return Redirect::to('/');
        }
        return View::make('signup/index');
    }

    /*
     * 新規会員登録：登録処理
     */
    public function postIndex(){
        $valid_rule = array(
            'username' => 'required|alpha_num|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4'
        );
        $validator = Validator::make(Input::all(), $valid_rule);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

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
            // グループIDを使用してグループを検索
            $userGroup = Sentry::findGroupById(2);
            // ユーザーにuserグループを割り当てる
            $user->addGroup($userGroup);
            // リダイレクト
            return Redirect::to('login'); 
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
