<?php namespace Owl\Http\Controllers;

use Owl\Models\Item;
use Owl\Repositories\StockRepositoryInterface;
use Owl\Repositories\TemplateRepositoryInterface;

class IndexController extends Controller
{
    protected $stockRepo;
    protected $templateRepo;

    public function __construct(StockRepositoryInterface $stockRepo, TemplateRepositoryInterface $templateRepo)
    {
        $this->stockRepo = $stockRepo;
        $this->templateRepo = $templateRepo;
    }

    public function index()
    {
        $items = Item::getAllItems();
        $templates = $this->templateRepo->getAll();
        $ranking_stock = $this->stockRepo->getRankingWithCache(5);
        return \View::make('index.index', compact('items', 'templates', 'ranking_stock'));
    }
}
