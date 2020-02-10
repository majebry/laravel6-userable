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
    public function handle($request, Closure $next, $userType, $guard = null)
    {
        if ($user = auth($guard)->user()) {
            $userableTypeNamespace = explode('\\', $user->userable_type);

            if (end($userableTypeNamespace) === Str::studly($userType)) {
                return $next($request);
            }
        }

        abort(403);
    }
}
