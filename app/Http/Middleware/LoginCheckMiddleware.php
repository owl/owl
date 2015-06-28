<?php namespace Owl\Http\Middleware;

use Closure;
use Owl\Services\UserService;

class LoginCheckMiddleware
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
        if (!$this->userService->getCurrentUser()) {
            return redirect('login');
        }

        return $next($request);
    }
}
