# Laravel XHGui

Small package to quickly configure a Laravel app to send profiling results to XHGui.
- [perftools/php-profiler](https://github.com/perftools/php-profiler)
- [perftools/xhgui](https://github.com/perftools/xhgui)

The package adds a global middleware that creates and starts a XHGui Profiler.

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

For example, `DefaultProfileEnabler` enables the profiler on every request.
In order to customize when the profiler runs, you can replace it with a class that extends `\Ritvarsz\LaravelXhgui\Support\SerializableClosure`
This can be usesful to profile only some requests.

```php
class CustomProfileEnabler extends SerializableClosure
{
    public function getClosure(): \Closure
    {
        // Profile only 1% of requests.
        return function () {
            return mt_rand(1, 100) === 69;
        };
    }
}
```
