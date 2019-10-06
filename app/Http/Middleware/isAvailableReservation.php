<?php

namespace App\Http\Middleware;

use App\Reservation;
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
       $reservations= Reservation::where('start','<=',now()->toDateString())
           ->where('done','!=',1)->get();
       $res= $reservations->first();
      if($res !=null){
          $studentsCount = $res->students->count();
          $maxStudents = $res->max_students;
          if( $studentsCount<$maxStudents)
              return $next($request);
          else if($studentsCount==$maxStudents){
              $res->update(['done'=>1]);
              return redirect('/error')->with('error','Reservation is Not Available');

          }
      }

        else{

            return redirect('/error')->with('error','Reservation is Not Available');

        }
    }
}
