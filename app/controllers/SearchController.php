<?php

class SearchController extends BaseController{

    private $_perPage = 10;

    public function index(){
        $q = Input::get('q');
        $offset = $this->calcOffset(Input::get('page'));
        $results = ItemFts::match($q, $this->_perPage, $offset);
        if(count($results) > 0){
            $res = ItemFts::matchCount($q);
            $pagination = Paginator::make($results, $res[0]->count, $this->_perPage);
        }
        $templates = Template::all();
        return View::make('search.index', compact('results', 'q', 'templates', 'pagination'));
    }

    private function calcOffset($page){
        if(empty($page))
            return 0;
        return (intval($page)-1) * $this->_perPage;
    }
}
