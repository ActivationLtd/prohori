<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if(\Request::get('ret') == 'json'){
                $ret = ret('success', "Already logged in", ['data' => \Auth::user()]);
                return \Response::json(fillRet($ret));
            }

            return redirect(route('home'));
        }

        return $next($request);
    }
}
