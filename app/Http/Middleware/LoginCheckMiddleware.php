<?php namespace Owl\Http\Middleware;

use Closure;
use Owl\Services\UserService;

class LoginCheckMiddleware
{
    protected $authService;

    public function __construct()
    {
        $this->userService = new UserService();
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
