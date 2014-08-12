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
		$stocks = Stock::with('user')->with('item')
                                ->where('user_id', $user->id)
				->orderBy('id','desc')
				->get();
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
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
