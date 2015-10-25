<?php namespace Owl\Http\Middleware;

use Closure;
use Owl\Services\AuthService;
use Owl\Services\UserService;

class AutoLoginMiddleware
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

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cookie = \Request::cookie('remember_token');
        if ($cookie && !\Session::has('User')) {
            $this->authService->autoLoginCheck();
        }

        // TODO: delete after release.
        $loginUser = $this->userService->getCurrentUser();
        if (!empty($loginUser) && !isset($loginUser->role)) {
            $user = $this->userService->getById($loginUser->id);
            $this->authService->setUser($user);
        }

        return $next($request);
    }
}
