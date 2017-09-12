<?php

namespace Bevy\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class company
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
        if (Auth::check() && Auth::user()->isRole() == "company")
        {
            return $next($request);
        }
        return redirect('login');// if this is not comppany the redirect to login

    }
}
