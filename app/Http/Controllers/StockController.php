<?php namespace Owl\Http\Controllers;

use Owl\Repositories\StockRepositoryInterface;
use Owl\Models\Item;
use Owl\Models\Template;
use Owl\Services\UserService;

class StockController extends Controller
{
    protected $userService;
    protected $stockRepo;

    public function __construct(UserService $userService, StockRepositoryInterface $stockRepo)
    {
        $this->userService = $userService;
        $this->stockRepo = $stockRepo;
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
        $templates = Template::all();
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
        $item = Item::where('open_item_id', $openItemId)->first();

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
        $item = Item::where('open_item_id', $openItemId)->first();

        $this->stockRepo->delete($user->id, $item->id);
    }
}
