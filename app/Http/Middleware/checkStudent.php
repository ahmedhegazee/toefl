<?php

namespace App\Http\Middleware;

use App\Student;
use Closure;
use Illuminate\Support\Facades\Cache;

class checkStudent
{
    public function isVerified()
    {

        return  auth()->user()->getStudent()->verified=='Verified';
    }
    public function CanEnterExam()
    {
        return  Cache::has('group-can-enter-exam-'.auth()->user()->getStudent()->group->id);

//            auth()->user()->getStudent()->enterexam==1;
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
            return redirect(route('error'))->with('error','You Are Not Verified');
        }else if( !$this->canEnterExam()){
            auth()->logout();
            return redirect(route('error'))->with('error','You Are Not Allowed to Enter Exam');
        }
        else
        return $next($request);
    }
}
