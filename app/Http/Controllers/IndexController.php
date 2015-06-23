<?php namespace Owl\Http\Controllers;

use Owl\Models\Item;
use Owl\Models\Template;
use Owl\Repositories\StockRepositoryInterface;

class IndexController extends Controller
{
    protected $stockRepo;

    public function __construct(StockRepositoryInterface $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    public function index()
    {
        $items = Item::getAllItems();
        $templates = Template::all();
        $ranking_stock = $this->stockRepo->getRankingWithCache(5);
        return \View::make('index.index', compact('items', 'templates', 'ranking_stock'));
    }
}
