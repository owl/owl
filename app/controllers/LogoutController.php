<?php
class LogoutController extends BaseController {

    public function __construct(){
    }

    public function getIndex(){
        if (Sentry::check()) {
            Session::forget("user");
            Sentry::logout();
        }
        return Redirect::to('login');
    }
}
