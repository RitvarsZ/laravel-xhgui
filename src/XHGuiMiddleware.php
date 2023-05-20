<?php

namespace Ritvarsz\LaravelXhgui;

use Closure;
use Illuminate\Http\Request;
use Ritvarsz\LaravelXhgui\Support\ProfileEnabler\ProfileEnablerFactory;
use Ritvarsz\LaravelXhgui\Support\ReplaceUrl\ReplaceUrlFactory;
use Ritvarsz\LaravelXhgui\Support\SimpleUrl\SimpleUrlFactory;
use Ritvarsz\LaravelXhgui\Support\SerializableClosure;
use Xhgui\Profiler\Profiler;
use Xhgui\Profiler\Config as ProfilerConfig;

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
        $config = config('xhgui');

        $enabler = ProfileEnablerFactory::create();
        $simpleUrl = SimpleUrlFactory::create();
        $replaceUrl = ReplaceUrlFactory::create();

        $config['profiler.enable'] = $enabler->getClosure();
        $config['profiler.simple_url'] = $simpleUrl->getClosure();
        $config['profiler.replace_url'] = is_subclass_of($replaceUrl, SerializableClosure::class)
            ? $replaceUrl->getClosure()
            : $replaceUrl;

        $profilerConfig = new ProfilerConfig($config);
        $profiler = new Profiler($profilerConfig);
        $profiler->start();

        return $next($request);
    }
}
