<?php namespace Owl\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Owl\Models\ItemFts;
use Owl\Models\TagFts;
use Owl\Models\User;
use Owl\Models\Template;

class SearchController extends Controller
{

    private $perPage = 10;

    public function index()
    {
        $q = \Input::get('q');
        $offset = $this->calcOffset(\Input::get('page'));
        $results = ItemFts::match($q, $this->perPage, $offset);
        if (count($results) > 0) {
            $res = ItemFts::matchCount($q);
            $pagination = new Paginator($results, $res[0]->count, $this->perPage, null, array('path' => '/search'));
        }
        $users = User::where('username', 'like', "$q%")->get();
        $templates = Template::all();
        $tags = $this->searchTags($q);
        return \View::make('search.index', compact('results', 'q', 'templates', 'pagination', 'tags', 'users'));
    }

    public function json()
    {
        return \Response::json(array(
            'list' => $this->jsonResults(\Input::get('q')),
            200
        ));
    }

    public function jsonp()
    {
        return \Response::json(array(
            'list' => $this->jsonResults(\Input::get('q')),
            200
        ))->setCallback(\Input::get('callback'));
    }

    private function searchTags($q)
    {
        $tagName = mb_strtolower($q);
        $tags = TagFts::match($q);
        foreach ($tags as &$tag) {
            $tag = (array)$tag;
        }
        return $tags;
    }

    private function jsonResults($q)
    {
        $items = ItemFts::match($q, $this->perPage);

        $json = array();
        foreach ($items as $item) {
            $json[] = array('title' => $item->title, 'url' => '://'.$_SERVER['HTTP_HOST'].'/items/'.$item->open_item_id);
        }
        return $json;
    }

    private function calcOffset($page)
    {
        if (empty($page)) {
            return 0;
        }
        return (intval($page)-1) * $this->perPage;
    }
}
