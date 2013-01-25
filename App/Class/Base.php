<?php

class Base
{
    protected static $instance;
    final public static function getSingleton() {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    final private function __clone() { }
}