<?php namespace Owl\Http\Controllers;

class IndexController extends Controller {

    public function index() {
        //$items = Item::getAllItems();
        //$templates = Template::all();
        //$ranking_stock = Stock::getRankingWithCache(5);
        //return View::make('index.index', compact('items', 'templates', 'ranking_stock'));
        return view('home');
    }
}
