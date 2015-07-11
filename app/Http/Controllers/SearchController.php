<?php namespace Owl\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Owl\Services\UserService;
use Owl\Repositories\ItemFtsRepositoryInterface;
use Owl\Repositories\TagFtsRepositoryInterface;
use Owl\Repositories\TemplateRepositoryInterface;

class SearchController extends Controller
{
    protected $perPage = 10;
    protected $templateRepo;
    protected $itemFtsRepo;
    protected $tagFtsRepo;
    protected $userService;

    public function __construct(
        TemplateRepositoryInterface $templateRepo,
        ItemFtsRepositoryInterface $itemFtsRepo,
        TagFtsRepositoryInterface $tagFtsRepo,
        UserService $userService
    ) {
        $this->templateRepo = $templateRepo;
        $this->itemFtsRepo = $itemFtsRepo;
        $this->tagFtsRepo = $tagFtsRepo;
        $this->userService = $userService;
    }

    public function index()
    {
        $q = \Input::get('q');
        $offset = $this->calcOffset(\Input::get('page'));
        $results = $this->itemFtsRepo->match($q, $this->perPage, $offset);
        if (count($results) > 0) {
            $res = $this->itemFtsRepo->matchCount($q);
            $pagination = new Paginator($results, $res[0]->count, $this->perPage, null, array('path' => '/search'));
        }
        $users = $this->userService->getLikeUsername($q);

        $templates = $this->templateRepo->getAll();
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
        $tags = $this->tagFtsRepo->match($q);
        foreach ($tags as &$tag) {
            $tag = (array)$tag;
        }
        return $tags;
    }

    private function jsonResults($q)
    {
        $items = $this->itemFtsRepo->match($q, $this->perPage);

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
