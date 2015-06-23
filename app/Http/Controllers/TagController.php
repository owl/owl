<?php namespace Owl\Http\Controllers;

use Owl\Models\Tag;
use Owl\Models\Item;
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

    public function index()
    {
        $tags = $this->tagService->getAllTags();
        $recent_ranking = $this->stockRepo->getRecentRankingWithCache(5, 7);
        $all_ranking = $this->stockRepo->getRankingWithCache(5);
        return view('tags.index', compact('tags', 'recent_ranking', 'all_ranking'));
    }

    public function show($tagName)
    {
        $tagName = mb_strtolower($tagName);
        $tag = Tag::where('name', $tagName)->first();

        if (empty($tag)) {
            \App::abort(404);
        }

        $items = Item::getRecentItemsByTagId($tag->id);

        return \View::make('tags.show', compact('tag', 'items'));
    }

    public function suggest()
    {
        $tags = Tag::all();

        $json = array();
        foreach ($tags as $tag) {
            $json[] = $tag->name;
        }
        return \Response::json($json);
    }
}
