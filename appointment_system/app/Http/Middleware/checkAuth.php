<?php

namespace App\Http\Middleware;

use Closure;

class checkAuth
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
        if((!session('is_authenticated')))
            return redirect('/login')->with('msg', 'Please Log In');
        
        else
            return $next($request);
    }
}
