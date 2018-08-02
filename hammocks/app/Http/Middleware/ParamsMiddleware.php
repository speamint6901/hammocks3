<?php

namespace App\Http\Middleware;

use Closure;

class ParamsMiddleware
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
        $params = $request->input();
        if (isset($params["sort"]) && ! empty($params["sort"])) {
            $config_key = "sort.".$params["sort_category"].".rep";
            $sortParams = \Config::get($config_key); 
            $key = $params["sort"];
            $split_sorts = explode(":", $sortParams[$key]);
            $request->merge(["sort" => $split_sorts[0]]);
            $request->merge(["sort_type" => $split_sorts[1]]);
        }
        return $next($request);
    }
}
