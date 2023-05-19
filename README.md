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

For configuration, see: https://github.com/perftools/php-profiler#config
