<?php namespace Owl\Http\Controllers;

use Owl\Services\UserService;
use Owl\Services\AuthService;
use Owl\Services\ItemService;
use Owl\Repositories\TemplateRepositoryInterface;
use Owl\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    protected $userService;
    protected $authService;
    protected $itemService;
    protected $templateRepo;

    public function __construct(
        UserService $userService,
        AuthService $authService,
        ItemService $itemService,
        TemplateRepositoryInterface $templateRepo
    ) {
        $this->userService = $userService;
        $this->authService = $authService;
        $this->itemService = $itemService;
        $this->templateRepo = $templateRepo;
    }

    /*
     * 新規会員登録：入力画面
     */
    public function signup()
    {
        if ($this->userService->getCurrentUser()) {
            return redirect('/');
        }
        return view('signup.index');
    }

    /*
     * 新規会員登録：登録処理
     */
    public function register(UserRegisterRequest $request)
    {
        $credentials = $request->only('username', 'email', 'password');
        try {
            $user = $this->userService->create($credentials);
            return \Redirect::to('login')->with('status', '登録が完了しました。');
        } catch (\Exception $e) {
            return \Redirect::back()
                ->withErrors(array('warning' => 'システムエラーが発生したため登録に失敗しました。'))
                ->withInput();
        }
    }

    public function show($username)
    {
        $loginUser = $this->userService->getCurrentUser();
        $user = $this->userService->getByUsername($username);
        if ($user == null) {
            \App::abort(404);
        }

        if ($loginUser->id === $user->id) {
            $items = $this->itemService->getRecentsByLoginUserIdWithPaginate($user->id);
        } else {
            $items = $this->itemService->getRecentsByUserIdWithPaginate($user->id);
        }

        $templates = $this->templateRepo->getAll();
        return \View::make('user.show', compact('user', 'items', 'templates'));
    }

    public function edit()
    {
        $templates = $this->templateRepo->getAll();
        return \View::make('user.edit', compact('templates'));
    }

    public function update()
    {
        $loginUser = $this->userService->getCurrentUser();

        // バリデーションルールの作成
        $valid_rule = array(
            "username" => "required|alpha_num|reserved_word|max:30|unique:users,username,$loginUser->id",
            "email" => "required|email|unique:users,email,$loginUser->id",
        );

        // バリデーション実行
        $validator = \Validator::make(\Input::all(), $valid_rule);

        // 失敗の場合
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $user = $this->userService->update($loginUser->id, \Input::get('username'), \Input::get('email'));

            if ($user) {
                $this->authService->setUser($user);
                return \Redirect::to('user/edit')->with('status', '編集が完了しました。');
            } else {
                \App::abort(500);
            }
        } catch (\Exception $e) {
            return \Redirect::back()
                ->withErrors(array('warning' => 'システムエラーが発生したため編集に失敗しました。'))
                ->withInput();
        }
    }

    public function password()
    {
        $loginUser = $this->userService->getCurrentUser();

        // バリデーションルールの作成
        $valid_rule = array(
            "password" => "required|alpha_num|min:4",
            "new_password" => "required|alpha_num|min:4",
        );

        // バリデーション実行
        $validator = \Validator::make(\Input::all(), $valid_rule);

        // 失敗の場合
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $user = $this->userService->getById($loginUser->id);

            if (!$this->authService->checkPassword($user->username, \Input::get('password'))) {
                return \Redirect::back()
                    ->withErrors(array('warning' => 'パスワードに誤りがあります。'))
                    ->withInput();
            }

            if ($this->authService->attemptResetPassword($user->username, \Input::get('new_password'))) {
                return \Redirect::to('user/edit')->with('status', 'パスワード変更が完了しました。');
            } else {
                return \Redirect::back()
                    ->withErrors(array('warning' => 'パスワードリセットに失敗しました。'))
                    ->withInput();
            }

        } catch (\Exception $e) {
            return \Redirect::back()
                ->withErrors(array('warning' => 'システムエラーが発生したためパスワードリセットに失敗しました。'))
                ->withInput();
        }
    }
}
