<?php

namespace App\Http\Middleware;

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
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put('student-is-online-' . Auth::user()->getStudent()->id, true, $expiresAt);

            return redirect()->route('student.home');
        }
    }
}
