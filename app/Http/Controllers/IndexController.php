<?php namespace Owl\Http\Controllers;

use Owl\Repositories\ItemRepositoryInterface;
use Owl\Repositories\StockRepositoryInterface;
use Owl\Repositories\TemplateRepositoryInterface;

class IndexController extends Controller
{
    protected $itemRepo;
    protected $stockRepo;
    protected $templateRepo;

    public function __construct(
        ItemRepositoryInterface $itemRepo,
        StockRepositoryInterface $stockRepo,
        TemplateRepositoryInterface $templateRepo
    ) {
        $this->itemRepo = $itemRepo;
        $this->stockRepo = $stockRepo;
        $this->templateRepo = $templateRepo;
    }

    public function index()
    {
        $items = $this->itemRepo->getAllPublished();
        $templates = $this->templateRepo->getAll();
        $ranking_stock = $this->stockRepo->getRankingWithCache(5);
        return \View::make('index.index', compact('items', 'templates', 'ranking_stock'));
    }
}
