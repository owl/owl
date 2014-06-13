<?php

class ItemController extends BaseController{

    public function show($id) {
        $user = Sentry::getUser();
        $item = Item::findOrFail($id);
        return View::make('items.show', compact('user','item'));
    }

    public function create() {
        $user = Sentry::getUser();
        return View::make('items.create', compact('user'));
    }

    public function postIndex() {
        $user = Sentry::getUser();
        DB::table('items')->insert([
            'title'=>Input::get('title'),
            'body'=>Input::get('body'),
            'user_id'=>$user->id,
            'published'=>Input::get('published'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return Redirect::to('/'); 
    }
}
