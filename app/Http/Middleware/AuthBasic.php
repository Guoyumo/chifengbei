<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthBasic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($return = Auth::onceBasic('email')) {
            return Response::json([
                    'code' => 403,
                    'status' => 'error',
                    'message' => 'invalid credentials'
                ]);
        }
        return $next($request);
    }
}
