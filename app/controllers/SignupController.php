<?php
class SignUpController extends BaseController {

    public function __construct(){
    }

    // 登録フォームの表示
    public function getIndex(){
        if (Sentry::check()) {
            return Redirect::to('/');
        }
        return View::make('signup/index');
    }

    public function postIndex(){
        $valid_rule = array(
            'email' => 'required|email|unique:users',
            'password' => 'required:min:4'
        );
        $validator = Validator::make(Input::all(), $valid_rule);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        try {
            // ユーザーの作成
            $user = Sentry::getUserProvider()->create(array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'activated' => 1,
            ));
            // グループIDを使用してグループを検索
            $userGroup = Sentry::getGroupProvider()->findById(3);
            // ユーザーにuserグループを割り当てる
            $user->addGroup($userGroup);
            // リダイレクト
            return Redirect::to('login'); 
        }catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::back()
                ->withErrors(array('warning' => 'Emailとパスワードを入力してください。'))
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
