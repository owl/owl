<?php namespace Owl\Http\Controllers;

use Owl\Services\UserService;
use Owl\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    /*
     * 新規会員登録：入力画面
     */
    public function signup()
    {
        return view('signup.index');
    }

    /*
     * 新規会員登録：登録処理
     */
    public function register(UserRegisterRequest $request){

        $credentials = $request->only('username', 'email', 'password');
        try {
            $user = $this->userService->createUser($credentials);
            return \Redirect::to('login')->with('status', '登録が完了しました。');
        } catch (\Exception $e) {
            return \Redirect::back()
                ->withErrors(array('warning' => 'システムエラーが発生したため登録に失敗しました。'))
                ->withInput();
        }
    }

    public function show($username){
        $LoginUser = Sentry::getUser();
        $user = User::where('username', '=', $username)->first();
        if ($user == null){
            App::abort(404);
        }

        if ($LoginUser->id === $user->id){
            $items = Item::with('user')
                        ->where('user_id', $user->id)
                        ->orderBy('id','desc')
                        ->paginate(10);
        } else {
            $items = Item::with('user')
                        ->where('published', '2')
                        ->where('user_id', $user->id)
                        ->orderBy('id','desc')
                        ->paginate(10);
        }

        $templates = Template::all();
        return View::make('user.show', compact('user', 'items', 'templates'));
    }

    public function edit(){
        $templates = Template::all();
        return View::make('user.edit', compact('templates'));
    }

    public function update(){
        $LoginUser = Sentry::getUser();

        // バリデーションルールの作成
        $valid_rule = array(
            "username" => "required|alpha_num|reserved_word|max:30|unique:users,username,$LoginUser->id",
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
                App::abort(500);
            }
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            echo 'User with this login already exists.';
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            echo 'User was not found.';
        }

    }

    public function reset(){
        $LoginUser = Sentry::getUser();

        // バリデーションルールの作成
        $valid_rule = array(
            "password" => "required|alpha_num|min:4",
            "new_password" => "required|alpha_num|min:4",
        );

        // バリデーション実行
        $validator = Validator::make(Input::all(), $valid_rule);

        // 失敗の場合
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $user = Sentry::findUserById($LoginUser->id);

            if(!$user->checkPassword(Input::get('password'))){
                return Redirect::back()
                    ->withErrors(array('warning' => 'パスワードに誤りがあります。'))
                    ->withInput();
            }

            $resetCode = $user->getResetPasswordCode();
            if (!$user->checkResetPasswordCode($resetCode)){
                return Redirect::back()
                    ->withErrors(array('warning' => 'パスワードリセットに失敗しました。'))
                    ->withInput();
            }

            if ($user->attemptResetPassword($resetCode, Input::get('new_password'))){
                return Redirect::to('user/edit')->with('status', 'パスワード変更が完了しました。');
            }else{
                return Redirect::back()
                    ->withErrors(array('warning' => 'パスワードリセットに失敗しました。'))
                    ->withInput();
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
