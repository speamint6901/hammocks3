<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
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
        if (\Auth::guest()) {
           if ($request->ajax() || $request->wantsJson()) {
               throw new \App\Exceptions\ApiAuthException("ログインして下さい");
           } else {
               //return \Redirect::to('/auth/login')->send();
               return redirect("auth/login");
           }
        }
        return $next($request);
    }
}
