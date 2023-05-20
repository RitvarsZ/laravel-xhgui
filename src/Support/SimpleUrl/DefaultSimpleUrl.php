<?php

namespace Ritvarsz\LaravelXhgui\Support\SimpleUrl;

use Ritvarsz\LaravelXhgui\Support\SerializableClosure;

class DefaultSimpleUrl extends SerializableClosure
{
    public function getClosure(): \Closure
    {
        return function ($url) {
            return preg_replace('/=\d+/', '', $url);
        };
    }
}