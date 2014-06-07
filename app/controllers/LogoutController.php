<?php
class LogoutController extends BaseController {

    public function __construct(){
    }

    public function getIndex(){
        if (Sentry::check()) {
            Sentry::logout();
        }
        return Redirect::to('login');
    }
}
