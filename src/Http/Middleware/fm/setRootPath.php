<?php

namespace ie\fm\Http\Middleware\fm;

use Closure;
use Illuminate\Http\Request;

class setRootPath
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       $request->mergeIfMissing(['rootPath'=>'/']);
        return $next($request);
    }
}
