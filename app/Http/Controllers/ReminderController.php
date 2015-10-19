<?php namespace Owl\Http\Controllers;

use Owl\Services\UserService;
use Owl\Services\AuthService;

class ReminderController extends Controller
{
    protected $userService;
    protected $authService;

    public function __construct(
        UserService $userService,
        AuthService $authService
    ) {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function remind()
    {
        return view('password.remind');
    }

    public function send()
    {
    }

    public function edit()
    {
    }

    public function update()
    {
    }
}
