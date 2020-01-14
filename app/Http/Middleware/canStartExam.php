<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class canStartExam
{
    public function isAbleToStartExam()
    {
        return Cache::has('group-can-start-exam-' . auth()->user()->getStudent()->group->id);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isAbleToStartExam())
            return $next($request);
        else
            return redirect()->back()->with('error', 'You are not allowed to start the exam');
    }
}
