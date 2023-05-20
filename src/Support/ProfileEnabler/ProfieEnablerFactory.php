<?php

namespace Ritvarsz\LaravelXhgui\Support\ProfileEnabler;

use Ritvarsz\LaravelXhgui\Exceptions\InvalidSerializableClosure;
use Ritvarsz\LaravelXhgui\Support\SerializeableClosure;

class ProfileEnablerFactory
{
    public static function create(): SerializeableClosure
    {
        $profileEnablerClass = static::getProfileEnablerClass();

        static::guardAgainstInvalidProfileEnabler($profileEnablerClass);

        return app($profileEnablerClass);
    }

    protected static function getProfileEnablerClass()
    {
        return config('xhgui')['profiler.enable'];
    }

    protected static function guardAgainstInvalidProfileEnabler(string $profileEnablerClass): void
    {
        if (!class_exists($profileEnablerClass)) {
            throw InvalidSerializableClosure::doesntExist($profileEnablerClass);
        }

        if (!is_subclass_of($profileEnablerClass, SerializeableClosure::class)) {
            throw InvalidSerializableClosure::doesNotImplementSerializableClosure($profileEnablerClass);
        }
    }
}