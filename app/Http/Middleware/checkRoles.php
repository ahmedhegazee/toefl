<?php

namespace App\Http\Middleware;

use App\Student;
use Closure;

class checkRoles
{
    public function isAdmin()
    {
        return auth()->user()->role->id!=2;
    }
    public function isStudent()
    {
        return auth()->user()->role->id==2;
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
            Student::where('uid',auth()->user()->id)
                ->update(['active'=>1]);
            return redirect()->route('student');}



    }
}
