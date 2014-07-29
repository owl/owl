<?php

class BaseController extends Controller {

	/**
	 * Construct
	 */
    public function __construct()
    {
        if(!Sentry::check() || !Session::has("user")){
            Session::forget("user");
            return Redirect::to('login');
        }
        $user = Session::get("user");
        View::share("User", $user);
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
