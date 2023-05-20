<?php

namespace Ritvarsz\LaravelXhgui\Support;

interface SerializableClosure
{
    public function getClosure(): \Closure;
}
