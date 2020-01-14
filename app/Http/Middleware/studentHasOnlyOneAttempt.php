<?php

namespace App\Http\Middleware;

use App\Attempt;
use Closure;

class studentHasOnlyOneAttempt
{
    public function hasAttempt()
    {
        $student =auth()->user()->getStudent();
      $attempt=  Attempt::where('student_id',$student->id)
        ->where('reservation_id',$student->reservation->id)
        ->where('group_id',$student->group->id)->get()->first();
//      dd($attempt);
            if(!is_null($attempt)) {
                if (!is_null($attempt->result))
                    return true;
            }
            else
        return false;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->hasAttempt()){
            auth()->logout();
            return redirect()->route('error')->with('error','you have only one attempt to take the exam');
        }

        return $next($request);
    }
}
