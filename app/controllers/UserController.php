<?php

class UserController extends BaseController{

    public function show($username){
        $user = User::where('username', '=', $username)->first();
        if ($user == null){
            App::abort(404);
        }
        return View::make('user.show', compact('user'));
    }

    public function edit(){
        return View::make('user.edit');
    }

    public function update(){
        $LoginUser = Sentry::getUser();

        // バリデーションルールの作成
        $valid_rule = array(
            "username" => "required|alpha_num|reserved_word|unique:users,username,$LoginUser->id",
            "email" => "required|email|unique:users,email,$LoginUser->id",
        );

        // バリデーション実行
        $validator = Validator::make(Input::all(), $valid_rule);

        // 失敗の場合
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $user = Sentry::findUserById($LoginUser->id);

            $user->username = Input::get('username');
            $user->email = Input::get('email');

            if($user->save()){
                return Redirect::to('user/edit')->with('status', '編集が完了しました。');
            }else{
    var_dump("hoge");exit;
                App::abort(500);
            }
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            echo 'User with this login already exists.';
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            echo 'User was not found.';
        }

    }


    public function stock(){

    } 

}
