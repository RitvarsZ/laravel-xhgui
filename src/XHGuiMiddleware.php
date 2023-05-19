<?php

namespace Ritvarsz\LaravelXhgui;

use Closure;
use Illuminate\Http\Request;
use Xhgui\Profiler\Profiler;
use Xhgui\Profiler\Config;

class XHGuiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $config = new Config(config('xhgui'));
        $profiler = new Profiler($config);
        $profiler->start();

        return $next($request);
    }
}
