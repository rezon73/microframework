<?php

abstract class Singleton
{
    protected static $instance = [];

    private function __construct() {}
    private function __clone() {}

    /**
     * @return static
     */
    public static function me()
    {
        if (empty(static::$instance[static::class])) {
            static::$instance[static::class] = new static();
        }

        return static::$instance[static::class];
    }
}