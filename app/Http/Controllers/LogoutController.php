<?php namespace Owl\Http\Controllers;

class LogoutController extends Controller {

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
