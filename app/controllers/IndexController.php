<?php

class IndexController extends BaseController {

    public function index() {
        $items = Item::with('user')
                    ->where('published', '2')
                    ->orderBy('id','desc')
                    ->paginate(10);
        $templates = Template::all();
        return View::make('index.index', compact('items', 'templates'));
    }

}
