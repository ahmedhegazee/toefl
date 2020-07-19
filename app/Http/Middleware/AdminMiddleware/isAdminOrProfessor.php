<?php

namespace App\Http\Middleware\AdminMiddleware;

use Closure;

class isAdminOrProfessor
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

        if (auth()->user()->isAdmin() || auth()->user()->isProfessor())
            return $next($request);
        else {
            auth()->logout();
            return redirect(route('error'))->with('error', 'Unauthorized Access');
        }
    }
}
