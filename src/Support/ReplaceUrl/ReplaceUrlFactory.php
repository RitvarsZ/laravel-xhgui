<?php

namespace Ritvarsz\LaravelXhgui\Support\ReplaceUrl;

use Ritvarsz\LaravelXhgui\Exceptions\InvalidSerializableClosure;
use Ritvarsz\LaravelXhgui\Support\SerializeableClosure;

class ReplaceUrlFactory
{
    /**
     * @return SerializeableClosure|null
     */
    public static function create()
    {
        $replaceUrlClass = static::getReplaceUrlClass();

        if (!$replaceUrlClass) {
            return null;
        }

        static::guardAgainstInvalidReplaceUrlClass($replaceUrlClass);

        return app($replaceUrlClass);
    }

    /**
     * @return string|null
     */
    protected static function getReplaceUrlClass()
    {
        return config('xhgui.profiler.replace_url');
    }

    protected static function guardAgainstInvalidReplaceUrlClass(string $replaceUrlClass): void
    {
        if (!class_exists($replaceUrlClass)) {
            throw InvalidSerializableClosure::doesntExist($replaceUrlClass);
        }

        if (!is_subclass_of($replaceUrlClass, SerializeableClosure::class)) {
            throw InvalidSerializableClosure::doesNotImplementSerializableClosure($replaceUrlClass);
        }
    }
}