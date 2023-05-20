<?php

namespace Ritvarsz\LaravelXhgui\Exceptions;

use Exception;
use Ritvarsz\LaravelXhgui\Support\SerializableClosure;

class InvalidSerializableClosure extends Exception
{
    public static function doesntExist(string $class): self
    {
        return new static("Serializable closure class `{$class}` doesn't exist");
    }

    public static function doesNotImplementSerializableClosure(string $class): self
    {
        $serializableClosureClass = SerializableClosure::class;

        return new static("Serializable closure class `{$class}` must implement `$serializableClosureClass`");
    }
}