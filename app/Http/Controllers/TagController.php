<?php namespace Owl\Http\Controllers;

use Owl\Services\TagService;
use Owl\Services\ItemService;
use Owl\Services\StockService;

class TagController extends Controller
{
    protected $tagService;
    protected $itemService;
    protected $stockService;

    public function __construct(
        TagService $tagService,
        ItemService $itemService,
        StockService $stockService
    ) {
        $this->tagService = $tagService;
        $this->itemService = $itemService;
        $this->stockService = $stockService;
    }

    /**
     * index
     *
     * @return view
     */
    public function index()
    {
        $tags = $this->tagService->getAllUsedTags();
        $recent_ranking = $this->stockService->getRecentRankingWithCache(5, 7);
        $all_ranking = $this->stockService->getRankingWithCache(5);
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

        $items = $this->itemService->getRecentsByTagId($tag->id);

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
