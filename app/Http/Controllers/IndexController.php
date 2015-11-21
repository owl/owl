<?php namespace Owl\Http\Controllers;

use Owl\Services\ItemService;
use Owl\Services\StockService;
use Owl\Services\TemplateService;

class IndexController extends Controller
{
    protected $itemService;
    protected $stockService;
    protected $templateService;

    public function __construct(
        ItemService $itemService,
        StockService $stockService,
        TemplateService $templateService
    ) {
        $this->itemService = $itemService;
        $this->stockService = $stockService;
        $this->templateService = $templateService;
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

        $templates = $this->templateService->getAll();
        $ranking_stock = $this->stockService->getRankingWithCache(5);
        return \View::make('index.index', compact('kind', 'items', 'templates', 'ranking_stock'));
    }
}
