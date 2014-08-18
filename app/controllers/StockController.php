<?php

class StockController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Sentry::getUser();
/*
                $stocks = Stock::with('user')->with('item')
                    ->where('user_id', $user->id)
                    ->orderBy('id','desc')
                    ->paginate(10);
*/
                $stocks = Stock::getStockList($user->id);
		$templates = Template::all();
		return View::make('stocks.index', compact('stocks', 'templates'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = Sentry::getUser();

		$openItemId = Input::get('open_item_id');
                $item = Item::where('open_item_id',$openItemId)->first();

                Stock::firstOrCreate(array('user_id'=> $user->id, 'item_id' => $item->id));

		return Response::json();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($openItemId)
	{
		$user = Sentry::getUser();
                $item = Item::where('open_item_id',$openItemId)->first();

		Stock::whereRaw('user_id = ? and item_id = ?', array($user->id, $item->id))->delete();
        }
}
