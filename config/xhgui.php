<?php

return [
    // Enable or disable the middleware. Useful for enabling via .env file.
    // If set to false, the global middleware that starts the profiler will not be registered.
    'enabled' => env('XHGUI_ENABLED', false),

    // This is the configuration for the perftools/php-profiler. See the README for more information.
    // Note that calling config('xhgui.<key>') will not work for these values.
    // If you must, you can use config('xhgui')['<key>.<key>'].
    'save.handler' => Xhgui\Profiler\Profiler::SAVER_UPLOAD,
    'save.handler.upload' => [
        'url' => 'http://xhgui/run/import',
        'timeout' => 3,
        'token' => 'token',
    ],
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
