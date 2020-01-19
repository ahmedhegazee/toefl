<?php

namespace App\Http\Middleware\AdminMiddleware;

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

    public function handle($request, Closure $next)
    {

        if(auth()->user()->isAdmin())
        return $next($request);
        else{
            auth()->logout();
            return redirect(route('error'))->with('error','Unauthorized <br/>You Are Not Admin');
        }

    }
}
