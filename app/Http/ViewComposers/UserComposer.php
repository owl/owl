<?php namespace Owl\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Owl\Services\UserService;

class UserComposer
{
    protected $user;

    /**
     * Create a UserComposer
     *
     * @param  UserService  $user
     * @return void
     */
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    /**
     * Share the user information to View
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('User', $this->user->getCurrentUser());
    }
}
