<?php namespace Owl\Http\Middleware;

use Closure;
use Owl\Services\AuthService;

class AutoLoginMiddleware
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
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

        return $next($request);
    }
}
