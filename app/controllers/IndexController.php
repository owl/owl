<?php

class IndexController extends BaseController {

    public function index() {
        $items = Item::getAllItems();
        $templates = Template::all();
        $ranking_stock = Stock::getRankingStockListWithCache(5);
        return View::make('index.index', compact('items', 'templates', 'ranking_stock'));
    }

}
