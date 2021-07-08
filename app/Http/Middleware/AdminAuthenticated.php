<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return \Illuminate\Http\Response
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() )
        {
            // allow admin to proceed with request
            if ( Auth::user()->isAdmin() ) {
                return $next($request);
            }
        }

        return response([
            'message' => 'Not Admin'
        ], 403);
    }
}
