<?php namespace Owl\Http\Controllers;

use Owl\Repositories\TemplateRepositoryInterface;
use Owl\Services\UserService;
use Owl\Services\ItemService;
use Owl\Services\StockService;

class StockController extends Controller
{
    protected $userService;
    protected $itemService;
    protected $stockService;
    protected $templateRepo;

    public function __construct(
        UserService $userService,
        ItemService $itemService,
        StockService $stockService,
        TemplateRepositoryInterface $templateRepo
    ) {
        $this->userService = $userService;
        $this->itemService = $itemService;
        $this->stockService = $stockService;
        $this->templateRepo = $templateRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = $this->userService->getCurrentUser();
        $stocks = $this->stockService->getStockList($user->id);
        $templates = $this->templateRepo->getAll();
        return \View::make('stocks.index', compact('stocks', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $user = $this->userService->getCurrentUser();

        $openItemId = \Input::get('open_item_id');
        $item = $this->itemService->getByOpenItemId($openItemId);

        $this->stockService->firstOrCreate($user->id, $item->id);

        return \Response::json();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($openItemId)
    {
        $user = $this->userService->getCurrentUser();
        $item = $this->itemService->getByOpenItemId($openItemId);

        $this->stockService->delete($user->id, $item->id);
    }
}
