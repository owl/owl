<?php

class ItemController extends BaseController{

    public function create(){
        $user = Sentry::getUser();
        return View::make('items.create', compact('user'));
    }

    public function store(){
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

    public function index(){
        $items = DB::table('items')->get();
        return View::make('items.index', compact('items'));
    }

    public function show($itemid){
        $user = Sentry::getUser();
        $item = DB::table('items')->where('id',$itemid)->first();
        return View::make('items.show', compact('user','item'));
    }

    public function edit($itemid){
        $user = Sentry::getUser();
        $item = DB::table('items')->where('id',$itemid)->first();
        return View::make('items.edit', compact('user','item'));
    }

    public function update($itemid){
        $user = Sentry::getUser();
        DB::table('items')->where('id', $itemid)->update([
            'title'=>Input::get('title'),
            'body'=>Input::get('body'),
            'user_id'=>$user->id,
            'published'=>Input::get('published'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return Redirect::route('items.show',[$itemid]);
    }
}
