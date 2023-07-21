<?php

namespace Ritvarsz\LaravelXhgui\Traits;

use Ritvarsz\LaravelXhgui\XHGuiMiddleware;

trait Profilable
{
    public function initXhprof()
    {
        // Should only run in console
        // HTTP requests are handled by XHGuiMiddleware
        // Though, havent seen any issues with starting the profiler multiple times.
        if (!app()->runningInConsole()) {
            return;
        }

        XHGuiMiddleware::enableProfiler();
    }
}