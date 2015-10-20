<?php namespace Owl\Http\Controllers;

use Owl\Services\UserService;
use Owl\Services\AuthService;
use Owl\Services\ReminderService;
use Owl\Http\Requests\ReminderSendRequest;

class ReminderController extends Controller
{
    protected $userService;
    protected $authService;
    protected $reminderService;

    public function __construct(
        UserService $userService,
        AuthService $authService,
        ReminderService $reminderService
    ) {
        $this->userService = $userService;
        $this->authService = $authService;
        $this->reminderService = $reminderService;
    }

    public function remind()
    {
        return view('password.remind');
    }

    public function send(ReminderSendRequest $request)
    {
        $email = $request->get('email');
        $user = $this->userService->getByEmail($email);

        if (empty($user)) {
            return view('password.send', compact('email'));
        }

        $token = $this->authService->createReminderToken();

        try {
            \DB::beginTransaction();

            $this->reminderService->create($user->id, $token);
            $this->reminderService->sendReminderMail($email, $token);

            \DB::commit();
        } catch (\Exception $e) {
            \Log::info($e);

            \DB::rollback();
            \App::abort(500);
        }

        return view('password.send', compact('email'));
    }

    public function edit()
    {
    }

    public function update()
    {
    }
}
