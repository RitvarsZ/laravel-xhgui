<?php

namespace Ritvarsz\LaravelXhgui;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
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
        }

        if (!config('xhgui.global.enabled')) {
            return;
        }

        $kernel = $this->app[Kernel::class];
        $kernel->prependMiddleware(XHGuiMiddleware::class);
    }
}
