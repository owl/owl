<?php namespace Owl\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    public function __construct()
    {
        $userService = new \Owl\Services\UserService();
        if ($user = $userService->getCurrentUser()) {
            \View::share("User", $user);
        }
    }

}
