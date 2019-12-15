<?php

namespace Majebry\LaravelUserable\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $userType)
    {
        $model = 'App\\' . Str::studly($userType);

        $user = auth()->user();
        
        if (!$user || ($user && $user->userable_type != $model)) {
            abort(403);
        }

        return $next($request);
    }
}
