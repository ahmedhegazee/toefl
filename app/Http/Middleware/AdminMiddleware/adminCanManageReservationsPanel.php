<?php

namespace App\Http\Middleware\AdminMiddleware;

use Closure;

class adminCanManageReservationsPanel
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
        if(auth()->user()->canManageReservationsPanel())
            return $next($request);
        else{
            return redirect(route('error'))->with('error','Unauthorized <br/>You Are Allowed To Enter This Sections');
        }

    }
}
