<?php

class IndexController extends BaseController {

    public function index() {
        $items = Item::getAllItems();
        $templates = Template::all();
        return View::make('index.index', compact('items', 'templates'));
    }

}
