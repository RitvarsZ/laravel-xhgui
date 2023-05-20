<?php

namespace Ritvarsz\LaravelXhgui\Support;

interface SerializeableClosure
{
    public function getClosure(): \Closure;
}
