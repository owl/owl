<?php

class BaseController extends Controller {

	/**
	 * Construct
	 */
    public function __construct()
    {
        if (!Sentry::check()){
            $user = Sentry::getUser();
            View::share("User", $user);
        } else {
            return Redirect::to('login');
        }

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
