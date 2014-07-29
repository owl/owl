<?php

class IndexController extends BaseController {

	public function index() {
        $items = Item::orderBy('id', 'desc')->get();
        return View::make('index.index', compact('items'));
	}

}
