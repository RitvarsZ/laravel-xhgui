<?php

namespace Ritvarsz\LaravelXhgui\Support\ReplaceUrl;

use Laravel\SerializableClosure\SerializableClosure;

class DefaultReplaceUrl extends SerializableClosure
{
    public function getClosure(): \Closure
    {
        return function ($url) {
            return $url;
        };
    }
}