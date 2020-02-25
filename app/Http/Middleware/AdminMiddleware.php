<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::check()){
            if (Auth::user()->is_admin) return $next($request);
            else return response()->json('Permission deny' , Response::HTTP_FORBIDDEN);
        }
            return response()->json('Unauthorized' , Response::HTTP_UNAUTHORIZED);
    }
}
