<?php
class LoginController extends BaseController {

    // ログインフォームの表示
    public function getIndex(){
        return View::make('login/index');
    }

}
