<?php

namespace Ritvarsz\LaravelXhgui;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Ritvarsz\LaravelXhgui\XHGuiMiddleware;

class XHProfServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     * 
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/config.php' => config_path('xhgui.php')], 'xhgui-config');
        }

        $kernel = $this->app[Kernel::class];
        $kernel->prependMiddleware(XHGuiMiddleware::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'xhgui');
    }
}
