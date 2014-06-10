<?php

class IndexController extends BaseController {

	public function index() {
        $user = Sentry::getUser();
        $items = Item::all();
        return View::make('index.index', compact('user','items'));
	}

    public function show($id) {
        $user = Sentry::getUser();
        $item = Item::findOrFail($id);
        return View::make('items.show', compact('user','item'));
    }

}
