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
    }

    public function stock(){

    } 

}
