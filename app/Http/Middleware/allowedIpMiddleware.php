<?php

namespace App\Http\Middleware;

use App\AllowedIP;
use Closure;
use Illuminate\Http\Request;

class allowedIpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(AllowedIP::where('ip',$request->ip())->get()->count()>0){

            return $next($request);
        }else{
            return redirect(route('error'))->with('error','you are not allowed to enter exam');
        }
    }
}
