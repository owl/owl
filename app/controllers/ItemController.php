<?php

class ItemController extends BaseController{

    public function create(){
        $user = Sentry::getUser();
        return View::make('items.create', compact('user'));
    }

    public function store(){
        $user = Sentry::getUser();
        $item = new Item;
        $item->fill(array(
            'user_id'=>$user->id,
            'title'=>Input::get('title'),
            'body'=>htmlspecialchars(Input::get('body'), ENT_QUOTES),
            'published'=>Input::get('published')
        ));
        $item->save();
        return Redirect::to('/'); 
    }

    public function index(){
        $user = Sentry::getUser();
        $items = Item::all();
        return View::make('items.index', compact('user','items'));
    }

    public function show($itemid){
        $user = Sentry::getUser();
        $item = Item::find($itemid);

        // Markdown Parse
        $parser = new \cebe\markdown\GithubMarkdown();
        $parser->enableNewlines = true;
        $item->body = $parser->parse($item->body);
        return View::make('items.show', compact('user','item'));
    }

    public function edit($itemid){
        $user = Sentry::getUser();
        $item = Item::find($itemid);
        return View::make('items.edit', compact('user','item'));
    }

    public function update($itemid){
        $user = Sentry::getUser();
        $item = Item::find($itemid);
        $item->fill(array(
            'user_id'=>$user->id,
            'title'=>Input::get('title'),
            'body'=>htmlspecialchars(Input::get('body'), ENT_QUOTES),
            'published'=>Input::get('published')
        ));
        $item->save();
        return Redirect::route('items.show',[$itemid]);
    }

    public function destroy($itemid){
        Item::find($itemid)->delete();
        return Redirect::route('items.index');
    }
}
