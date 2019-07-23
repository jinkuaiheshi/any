<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        $islogin = session('islogin');
        if(!$islogin){
            return redirect('admin/login');
        }
        view()->share('info',$islogin);
        return $next($request);
    }
}
