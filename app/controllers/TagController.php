<?php

class TagController extends BaseController{

    public function show($tagName){
        $tagName = mb_strtolower($tagName);
        $tag = Tag::where('name', $tagName)->first();

        if (empty($tag)){
            App::abort(404);
        }

        $items = Item::getRecentItemsByTagId($tag->id);

        return View::make('tags.show', compact('tag', 'items'));
    }
}
