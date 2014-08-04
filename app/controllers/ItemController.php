<?php

class ItemController extends BaseController{

    public function create(){
        return View::make('items.create');
    }

    public function store(){
        $user = Sentry::getUser();
        $item = new Item;
        $item->fill(array(
            'user_id'=>$user->id,
            'title'=>Input::get('title'),
            'body'=>Input::get('body'),
            'published'=>Input::get('published')
        ));
        $item->save();
        return Redirect::to('/'); 
    }

    public function index(){
        $items = Item::all();
        return View::make('items.index', compact('items'));
    }

    public function show($itemid){
        $item = Item::find($itemid);

        // Markdown Parse
        $parser = new CustomMarkdown;
        $parser->enableNewlines = true;
        $item->body = $parser->parse($item->body);
        return View::make('items.show', compact('item'));
    }

    public function edit($itemid){
        $item = Item::find($itemid);
        return View::make('items.edit', compact('item'));
    }

    public function update($itemid){
        $user = Sentry::getUser();
        $item = Item::find($itemid);
        $item->fill(array(
            'user_id'=>$user->id,
            'title'=>Input::get('title'),
            'body'=>htmlspecialchars(Input::get('body'), ENT_QUOTES, 'UTF-8'),
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
