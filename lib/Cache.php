<?php

class Cache extends Memcached
{
    /**
     * @var Cache
     */
    protected static $instance = null;

    private function __clone() {}

    /**
     * @return $this
     */
    public static function me()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();

            $config = Config::me()->get('memcached');
            static::$instance->addServer($config['host'], $config['port']);
        }

        return static::$instance;
    }
}