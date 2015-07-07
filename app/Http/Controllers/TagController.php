<?php namespace Owl\Http\Controllers;

use Owl\Models\Item;
use Owl\Repositories\Eloquent\Models\Tag;
use Owl\Repositories\StockRepositoryInterface;
use Owl\Services\TagService;

class TagController extends Controller
{
    protected $tagService;
    protected $stockRepo;

    public function __construct(TagService $tagService, StockRepositoryInterface $stockRepo)
    {
        $this->tagService = $tagService;
        $this->stockRepo = $stockRepo;
    }

    /**
     * index
     *
     * @return view
     */
    public function index()
    {
        $tags = $this->tagService->getAllUsedTags();
        $recent_ranking = $this->stockRepo->getRecentRankingWithCache(5, 7);
        $all_ranking = $this->stockRepo->getRankingWithCache(5);
        return view('tags.index', compact('tags', 'recent_ranking', 'all_ranking'));
    }

    /**
     * show
     *
     * @param string $tagName
     * @return view
     */
    public function show($tagName)
    {
        $tagName = mb_strtolower($tagName);
        $tag = $this->tagService->getByName($tagName);

        if (empty($tag)) {
            \App::abort(404);
        }

        $items = Item::getRecentItemsByTagId($tag->id);

        return \View::make('tags.show', compact('tag', 'items'));
    }

    /**
     * suggest
     *
     * @return json
     */
    public function suggest()
    {
        $tags = $this->tagService->getAll();

        $json = array();
        foreach ($tags as $tag) {
            $json[] = $tag->name;
        }
        return \Response::json($json);
    }
}
