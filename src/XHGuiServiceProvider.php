<?php

namespace Ritvarsz\LaravelXhgui;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Ritvarsz\LaravelXhgui\Actions\ExpireRuns;
use Ritvarsz\LaravelXhgui\XHGuiMiddleware;

class XHGuiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     * 
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/xhgui.php' => config_path('xhgui.php')], 'xhgui-config');

            return;
        }

        if (!config('xhgui.enabled')) {
            return;
        }

        // Cleanup old runs
        try {
            $this->app->make(ExpireRuns::class)->handle();
        } catch (\Exception $e) {
            Log::error('Failed to cleanup old XHGui runs: ' . $e->getMessage());
        }

        // Add the middleware
        $kernel = $this->app[Kernel::class];
        $kernel->prependMiddleware(XHGuiMiddleware::class);
    }
}
