<?php

namespace App\Http\Middleware\StudentMiddlewares;

use App\Exam;
use App\Student;
use Closure;
use Illuminate\Support\Facades\Cache;

class canStartExam
{
    public function isAbleToStartExam(Student $student)
    {
        return $student->CanStartExam();
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
        $student =auth()->user()->getStudent();

         if ($this->isAbleToStartExam($student))
            return $next($request);
        else
            return redirect()->back()->with('error', 'You are not allowed to start the exam');

    }
}
