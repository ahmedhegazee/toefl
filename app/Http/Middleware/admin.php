<?php

namespace App\Http\Middleware;

use Closure;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function isAdmin()
    {
        return auth()->user()->roles->contains(1) ;
    }
    public function handle($request, Closure $next)
    {

        if($this->isAdmin())
        return $next($request);
        else{
            auth()->logout();
            return redirect(route('error'))->with('error','Unauthorized <br/>You Are Not Admin');
        }

    }
}
