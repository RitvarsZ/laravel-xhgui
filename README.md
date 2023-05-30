# Laravel XHGui

Small package to quickly configure a Laravel app to send profiling results to XHGui.
- [perftools/php-profiler](https://github.com/perftools/php-profiler)
- [perftools/xhgui](https://github.com/perftools/xhgui)

The package adds a global middleware that starts php-profiler.

## Installation
```bash
composer require ritvarsz/laravel-xhgui
```

Publish the config:
```bash
php artisan vendor:publish --tag=xhgui-config
```

## Configuration

For configuration, see: [https://github.com/perftools/php-profiler#config]

Important note: some php-profiler config values are defined as callbacks. Laravel cannot cache the config if it contains callbacks.
So we have implemented a simple class that stores the callback - supported config keys are:
```php
[
    'profiler.enable' => \Ritvarsz\LaravelXhgui\Support\ProfileEnabler\DefaultProfileEnabler::class,
    'profiler.simple_url' => \Ritvarsz\LaravelXhgui\Support\SimpleUrl\DefaultSimpleUrl::class,
    'profiler.replace_url' => \Ritvarsz\LaravelXhgui\Support\ReplaceUrl\DefaultReplaceUrl::class,
]
```

### Default configuration
```php
return [
    // Enable or disable the middleware. Useful for enabling via .env file.
    // If set to false, the global middleware that starts the profiler will not be registered.
    'enabled' => env('XHGUI_ENABLED', false),

    // Settings for used by DefaultProfileEnabler
    'enabler' => [
        // Enable profiling for every 1/n requests. Setting 
        // this to 100 will profile approx 1% of requests.
        // By default, profile every request.
        'probablility' => env('XHGUI_PROBABILITY', 1),

        // Route patterns to exclude or include from profiling.
        // Env var should be a comma-separated list of patterns.
        // If both exclude and include are set, include takes precedence (exclude is ignored).
        // DefaultProfileEnabler uses \Illuminate\Support\Str::is() to match patterns.
        // Example: XHGUI_ROUTE_EXCLUDE=api/users/*/profile/*,api/ping
        'include_routes' => env('XHGUI_ROUTE_INCLUDE', ''),
        'exclude_routes' => env('XHGUI_ROUTE_EXCLUDE', ''),
    ],

    // This is the configuration for the perftools/php-profiler. See the README for more information.
    // Note that calling config('xhgui.<key>') will not work for these values.
    // If you must, you can use config('xhgui')['<key>.<key>'].
    'save.handler' => Xhgui\Profiler\Profiler::SAVER_UPLOAD,
    'save.handler.upload' => [
        'url' => env('XHGUI_UPLOAD_URL', 'http://xhgui/run/import'),
        'timeout' => 3,
        'token' => env('XHGUI_UPLOAD_TOKEN', ''),
    ],

    // The default enabler class uses enabler settings from above to determine if the profiler should run.
    'profiler.enable' => \Ritvarsz\LaravelXhgui\Support\ProfileEnabler\DefaultProfileEnabler::class,
    'profiler.flags' => [
        Xhgui\Profiler\ProfilingFlags::CPU,
        Xhgui\Profiler\ProfilingFlags::MEMORY,
        Xhgui\Profiler\ProfilingFlags::NO_BUILTINS,
        Xhgui\Profiler\ProfilingFlags::NO_SPANS,
    ],
    'profiler.options' => [],
    'profiler.exclude-env' => [],
    'profiler.simple_url' => \Ritvarsz\LaravelXhgui\Support\SimpleUrl\DefaultSimpleUrl::class,
    'profiler.replace_url' => \Ritvarsz\LaravelXhgui\Support\ReplaceUrl\DefaultReplaceUrl::class,
];
```

### Profiling enabler class
The default profile enabler uses `enabler.probability`, `enabler.exclude` and `enabler.include` config parameters to determine if the current request should be profiled. 
Feel free to make your own class that implements `\Ritvarsz\LaravelXhgui\Support\SerializableClosure` to override the logic or extend the `DefaultProfileEnabler` to add more constraints.

## Todo:
- Support for profiling artisan commands.
- Support for profiling jobs.
