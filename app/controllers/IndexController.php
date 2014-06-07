<?php

class IndexController extends BaseController {

	public function index()
    {
        $user = Sentry::getUser();
        return View::make('index/index', compact('user'));
	}

}
