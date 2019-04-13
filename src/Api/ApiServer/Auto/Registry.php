<?php

namespace AutoApiServer\Api\ApiServer\Auto;


class Registry
{
    private function __construct()
    {
    }

    private static $registry = [];

    public static function addValue(string $name, $value)
    {
        self::$registry[$name] = $value;
    }

    public static function getValue(string $name)
    {
        return self::$registry[$name];
    }
}
