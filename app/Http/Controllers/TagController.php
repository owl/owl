<?php namespace Owl\Http\Controllers;

use Owl\Repositories\Tag;
use Owl\Repositories\Item;

class TagController extends Controller {

    private $_perPage = 10;

    public function show($tagName){
        $tagName = mb_strtolower($tagName);
        $tag = Tag::where('name', $tagName)->first();

        if (empty($tag)){
            \App::abort(404);
        }

        $items = Item::getRecentItemsByTagId($tag->id);

        return \View::make('tags.show', compact('tag', 'items'));
    }

    public function suggest(){
        $tags = Tag::all();

        $json = array();
        foreach($tags as $tag){
            $json[] = $tag->name;
        }
        return \Response::json($json);
    }
}
