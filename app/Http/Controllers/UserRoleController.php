<?php namespace Owl\Http\Controllers;

use Owl\Services\UserService;
use Owl\Services\AuthService;
use Owl\Services\UserRoleService;

class UserRoleController extends Controller
{
    protected $userService;
    protected $authService;
    protected $userRoleService;

    public function __construct(
        UserService $userService,
        AuthService $authService,
        UserRoleService $userRoleService
    ) {
        $this->userService = $userService;
        $this->authService = $authService;
        $this->userRoleService = $userRoleService;
    }

    public function initial()
    {
        $owners = $this->userService->getOwners();
        if (! empty($owners)) {
            \App::abort(500);
        }

        $user = $this->userService->getCurrentUser();
        if ($user == null) {
            \App::abort(404);
        }

        return view('user.role.initial', compact('user'));
    }

    public function initialRegister()
    {
        $owners = $this->userService->getOwners();
        if (! empty($owners)) {
            \App::abort(500);
        }

        $user = $this->userService->getCurrentUser();
        if ($user == null) {
            \App::abort(404);
        }

        $user->role = UserRoleService::ROLE_ID_OWNER;
        $updateUser = $this->userService->update($user->id, $user->username, $user->email, $user->role);
        $this->authService->setUser($updateUser);

        return view('user.role.initialComplete');
    }
}
