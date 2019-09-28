<?php

namespace App\Http\Middleware;

use App\Student;
use Closure;

class checkStudent
{
    public function isVerified()
    {
        return  Student::where('uid',auth()->user()->id)->get()[0]->verified==1;
    }
    public function CanEnterExam()
    {
        return  Student::where('uid',auth()->user()->id)->get()[0]->enterexam==1;
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
        if(!$this->isVerified()){
            auth()->logout();
            return redirect('/error')->with('error','You Are Not Verified');
        }else if( !$this->canEnterExam()){
            auth()->logout();
            return redirect('/error')->with('error','You Are Not Allowed to Enter Exam');
        }
        else
        return $next($request);
    }
}
