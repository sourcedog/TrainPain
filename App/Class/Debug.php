<?php

class Debug
{
    public static function print_r($data)
    {
        ob_start();
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        echo ob_get_clean();
    }
}