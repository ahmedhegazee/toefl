<?php

namespace App\Http\Middleware\StudentMiddlewares;

use App\Student;
use Closure;
use Illuminate\Support\Facades\Cache;

class checkStudent
{
    public function isVerified()
    {
        return  auth()->user()->getStudent()->isVerified();
    }
    public function CanEnterExam()
    {
        return  auth()->user()->getStudent()->CanEnterExam();

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
//dd('hello');
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
