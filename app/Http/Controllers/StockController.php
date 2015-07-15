<?php namespace Owl\Http\Controllers;

use Owl\Repositories\StockRepositoryInterface;
use Owl\Repositories\TemplateRepositoryInterface;
use Owl\Repositories\ItemRepositoryInterface;
use Owl\Services\UserService;

class StockController extends Controller
{
    protected $userService;
    protected $stockRepo;
    protected $itemRepo;
    protected $templateRepo;

    public function __construct(
        UserService $userService,
        StockRepositoryInterface $stockRepo,
        ItemRepositoryInterface $itemRepo,
        TemplateRepositoryInterface $templateRepo
    ) {
        $this->userService = $userService;
        $this->stockRepo = $stockRepo;
        $this->itemRepo = $itemRepo;
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
        $stocks = $this->stockRepo->getStockList($user->id);
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
        $item = $this->itemRepo->getByOpenItemId($openItemId);

        $this->stockRepo->firstOrCreate($user->id, $item->id);

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
        $item = $this->itemRepo->getByOpenItemId($openItemId);

        $this->stockRepo->delete($user->id, $item->id);
    }
}
