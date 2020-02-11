<?php

namespace App\Http\Middleware;

use App\Attempt;
use App\Student;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class checkRoles
{
    public function isAdmin()
    {
        return auth()->user()->roles->contains(1);
    }
    public function isStudent()
    {
        return auth()->user()->roles->contains(2);
    }
    public function hasAttempt()
    {
        $student =auth()->user()->getStudent();
        $attempt=  Attempt::where('student_id',$student->id)
            ->where('reservation_id',$student->reservation->id)
            ->where('group_id',$student->group->id)->get()->first();
//      dd($attempt);
        if(!is_null($attempt)) {
//                if (!is_null($attempt->result))
            return true;
        }
        else
            return false;
    }

    public function isOnline()
    { $student =auth()->user()->getStudent();
        return $student->isOnline()=='active';
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
        if($this->isAdmin())
            return redirect()->route('admin');
        else if($this->isStudent())
        {
            if($this->hasAttempt()&&$this->isOnline()){
                auth()->logout();
                return redirect()->route('error')->with('error','you have only one attempt to take the exam');
            }else{
                $expiresAt = Carbon::now()->addMinutes(5);
                Cache::put('student-is-online-' . Auth::user()->getStudent()->id, true, $expiresAt);

                return redirect()->route('student.home');
            }

        }
    }
}
