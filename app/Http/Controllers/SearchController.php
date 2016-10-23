<?php namespace Owl\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Owl\Services\UserService;
use Owl\Services\SearchService;
use Owl\Services\TemplateService;

class SearchController extends Controller
{
    protected $perPage = 10;
    protected $userService;
    protected $searchService;
    protected $templateService;

    public function __construct(
        UserService $userService,
        SearchService $searchService,
        TemplateService $templateService
    ) {
        $this->userService = $userService;
        $this->searchService = $searchService;
        $this->templateService = $templateService;
    }

    public function index()
    {
        $q = \Input::get('q');
        $offset = $this->calcOffset(\Input::get('page'));
        $results = $this->searchService->itemMatch($q, $this->perPage, $offset);
        if (count($results) > 0) {
            $count = $this->searchService->itemMatchCount($q);
            $pagination = new Paginator($results, $count, $this->perPage, null, array('path' => '/search'));
        }
        $users = $this->userService->getLikeUsername($q);
        $users_array = $this->userService->getUsersToArray($users);

        $templates = $this->templateService->getAll();
        $tags = $this->searchTags($q);
        return \View::make(
            'search.index',
            compact('results', 'q', 'templates', 'pagination', 'tags', 'users', 'users_array')
        );
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
        $tags = $this->searchService->tagMatch($q);
        foreach ($tags as &$tag) {
            $tag = (array)$tag;
        }
        return $tags;
    }

    private function jsonResults($q)
    {
        $items = $this->searchService->itemMatch($q, $this->perPage);

        $json = array();
        foreach ($items as $item) {
            $json[] = [
                'title' => $item->title,
                'url' => '://'.$_SERVER['HTTP_HOST'].'/items/'.$item->open_item_id
            ];
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
