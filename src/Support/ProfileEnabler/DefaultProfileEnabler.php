<?php

namespace Ritvarsz\LaravelXhgui\Support\ProfileEnabler;

use Laravel\SerializableClosure\SerializableClosure;

/**
 * By default, the profiler is enabled for all requests.
 */
class DefaultProfileEnabler extends SerializableClosure
{
    public function getClosure(): \Closure
    {
        return function () {
            return true;
        };
    }
}
