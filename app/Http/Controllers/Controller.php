<?php namespace Owl\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Owl\Services\UserService;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    protected $userService;
    protected $currentUser;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        if ($this->currentUser = $this->userService->getCurrentUser()) {
            \View::share("User", $this->currentUser);
        }
    }
}
