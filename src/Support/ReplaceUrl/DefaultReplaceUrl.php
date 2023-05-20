<?php

namespace Ritvarsz\LaravelXhgui\Support\ReplaceUrl;

use Ritvarsz\LaravelXhgui\Support\SerializableClosure;

class DefaultReplaceUrl extends SerializableClosure
{
    public function getClosure(): \Closure
    {
        return function ($url) {
            return $url;
        };
    }
}