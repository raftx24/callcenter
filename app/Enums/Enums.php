<?php

namespace App\Enums;

use ReflectionClass;

class Enums
{
    public static function values()
    {
        return array_values(self::getConstants());
    }

    public static function toString($value)
    {
        return array_flip(self::getConstants())[$value];
    }

    protected static function getConstants(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }
}
