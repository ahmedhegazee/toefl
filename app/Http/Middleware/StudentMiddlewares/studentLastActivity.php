<?php

namespace App\Http\Middleware\StudentMiddlewares;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class studentLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()&&!is_null(Auth::user()->getStudent())) {
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put('student-is-online-' . Auth::user()->getStudent()->id, true, $expiresAt);
        }
        return $next($request);
    }
}
