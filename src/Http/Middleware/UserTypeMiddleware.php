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
        $model = [
            'Majebry\\LaravelAuthWrapper\\' . Str::studly($userType),
            'App\\' . Str::studly($userType)
        ];

        $user = auth('api')->user();

        if (!$user || ($user && !in_array($user->userable_type, $model))) {
            abort(403);
        }

        return $next($request);
    }
}
