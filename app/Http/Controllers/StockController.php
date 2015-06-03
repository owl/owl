<?php namespace Owl\Http\Controllers;

use Owl\Models\Stock;
use Owl\Models\Item;
use Owl\Models\Template;
use Owl\Services\UserService;

class StockController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = $this->userService->getCurrentUser();
        $stocks = Stock::getStockList($user->id);
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

        Stock::firstOrCreate(array('user_id'=> $user->id, 'item_id' => $item->id));

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

        Stock::whereRaw('user_id = ? and item_id = ?', array($user->id, $item->id))->delete();
    }
}
