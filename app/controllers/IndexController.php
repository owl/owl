<?php

class IndexController extends BaseController {

	public function index() {
        $user = Sentry::getUser();
        $items = Item::orderBy('id', 'desc')->get();
        return View::make('index.index', compact('user','items'));
	}

}
