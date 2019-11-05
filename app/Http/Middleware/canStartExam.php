<?php

namespace App\Http\Middleware;

use Closure;

class canStartExam
{
    public function isAbleToStartExam()
    {
        return auth()->user()->getStudent()->startexam==1;
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
        if($this->isAbleToStartExam())
        return $next($request);
        else
            return redirect()->back()->with('error','You are not allowed to start the exam');
    }
}
