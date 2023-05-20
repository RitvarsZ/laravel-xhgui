<?php

namespace Ritvarsz\LaravelXhgui\Support\ProfileEnabler;

use Ritvarsz\LaravelXhgui\Support\SerializableClosure;

/**
 * By default, the profiler is enabled for all requests.
 */
class DefaultProfileEnabler implements SerializableClosure
{
    public function getClosure(): \Closure
    {
        return function () {
            return true;
        };
    }
}
