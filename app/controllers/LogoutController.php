<?php
class LogoutController extends BaseController {

    public function __construct(){
    }

    public function logout(){
        if (Sentry::check()) {
            Session::forget("User");
            Sentry::logout();
        }
        return Redirect::to('login');
    }
}
