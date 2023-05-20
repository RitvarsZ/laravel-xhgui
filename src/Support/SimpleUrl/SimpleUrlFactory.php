<?php

namespace Ritvarsz\LaravelXhgui\Support\SimpleUrl;

use Ritvarsz\LaravelXhgui\Exceptions\InvalidSerializableClosure;
use Ritvarsz\LaravelXhgui\Support\SerializableClosure;

class SimpleUrlFactory
{
    public static function create(): SerializableClosure
    {
        $simpleUrlClass = static::getSimpleUrlClass();

        static::guardAgainstInvalidSimpleUrlClass($simpleUrlClass);

        return app($simpleUrlClass);
    }

    /**
     * @return string|null
     */
    protected static function getSimpleUrlClass()
    {
        return config('xhgui')['profiler.simple_url'];
    }

    protected static function guardAgainstInvalidSimpleUrlClass(string $simpleUrlClass): void
    {
        if (!class_exists($simpleUrlClass)) {
            throw InvalidSerializableClosure::doesntExist($simpleUrlClass);
        }

        if (!is_subclass_of($simpleUrlClass, SerializableClosure::class)) {
            throw InvalidSerializableClosure::doesNotImplementSerializableClosure($simpleUrlClass);
        }
    }
}