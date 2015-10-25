<?php namespace Owl\Http\Middleware;

use Closure;
use Owl\Services\UserService;
use Owl\Services\UserRoleService;

class OwnerCheckMiddleware
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->userService->getCurrentUser();

        if ($user->role != UserRoleService::ROLE_ID_OWNER) {
            return redirect('/');
        }

        return $next($request);
    }
}
