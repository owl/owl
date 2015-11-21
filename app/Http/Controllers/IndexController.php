<?php namespace Owl\Http\Controllers;

use Owl\Services\ItemService;
use Owl\Services\StockService;
use Owl\Repositories\TemplateRepositoryInterface;

class IndexController extends Controller
{
    protected $itemService;
    protected $stockService;
    protected $templateRepo;

    public function __construct(
        ItemService $itemService,
        StockService $stockService,
        TemplateRepositoryInterface $templateRepo
    ) {
        $this->itemService = $itemService;
        $this->stockService = $stockService;
        $this->templateRepo = $templateRepo;
    }

    public function index()
    {
        $kind = (\Input::get('kind')) ?: 'stock';

        if ($kind === 'all') {
            $items = $this->itemService->getAllPublished();
        } elseif ($kind === 'flow') {
            $items = $this->itemService->getAllFlowPublished();
        } else {
            $kind = 'stock';
            $items = $this->itemService->getAllStockPublished();
        }

        $templates = $this->templateRepo->getAll();
        $ranking_stock = $this->stockService->getRankingWithCache(5);
        return \View::make('index.index', compact('kind', 'items', 'templates', 'ranking_stock'));
    }
}
