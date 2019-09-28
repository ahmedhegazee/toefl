<?php

namespace App\Http\Middleware;

use App\Resarvation;
use Closure;

class isAvailableReservation
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
       $res= Resarvation::where('start','<=',now()->toDateString())
           ->where('end','>=',now()->toDateString())
           ->where('done','!=',1)->get();
        if($res->count()>0)
        return $next($request);
        else
            return redirect('/error')->with('error','Reservation is Not Available');
    }
}
