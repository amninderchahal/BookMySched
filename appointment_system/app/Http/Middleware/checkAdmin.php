<?php

namespace App\Http\Middleware;

use Closure;

class checkAdmin
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
        $role_id = session('role_id');
        
        if($role_id==1||$role_id==2)
            return $next($request);
        else
            return redirect('error')->with('error', 'You are not authorized');
    }
}
