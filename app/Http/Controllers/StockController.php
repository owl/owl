<?php namespace Owl\Http\Controllers;

use Illuminate\Contracts\Events\Dispatcher;
use Owl\Services\UserService;
use Owl\Services\ItemService;
use Owl\Services\StockService;
use Owl\Services\TemplateService;
use Owl\Events\Item\FavoriteEvent;

class StockController extends Controller
{
    protected $userService;
    protected $itemService;
    protected $stockService;
    protected $templateService;

    public function __construct(
        UserService $userService,
        ItemService $itemService,
        StockService $stockService,
        TemplateService $templateService
    ) {
        $this->userService = $userService;
        $this->itemService = $itemService;
        $this->stockService = $stockService;
        $this->templateService = $templateService;
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
        $templates = $this->templateService->getAll();
        return \View::make('stocks.index', compact('stocks', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Dispatcher  $event
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Dispatcher $event)
    {
        $user = $this->userService->getCurrentUser();

        $openItemId = \Input::get('open_item_id');
        $item = $this->itemService->getByOpenItemId($openItemId);

        $this->stockService->firstOrCreate($user->id, $item->id);

        // fire FavoriteEvent
        // TODO: do not generate instance in controller method
        $event->fire(new FavoriteEvent(
            $openItemId,
            (int) $user->id
        ));

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
