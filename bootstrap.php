<?php

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__));

ini_set('display_errors', 'on');
error_reporting(E_ALL ^ E_NOTICE);

spl_autoload_register(function ($class) {
    $modelFile = dirname(__FILE__) . DS . 'App' . DS . str_replace("\\", "/", $class) . '.php';
    if(file_exists($modelFile)) {
        require_once($modelFile);
    }
});

spl_autoload_register(function ($class) {
    $classFile = dirname(__FILE__) . DS . 'App/Class' . DS . str_replace("\\", "/", $class) . '.php';
    if(file_exists($classFile)) {
        require_once($classFile);
    }
});

function makePrettyException(Exception $e)
{
    $trace = $e->getTrace();

    $result = 'Exception: "';
    $result .= $e->getMessage();
    $result .= '" @ ';
    if($trace[0]['class'] != '') {
        $result .= $trace[0]['class'];
        $result .= '->';
    }
    $result .= $trace[0]['function'];
    $result .= '();<br />';

    return $result;
}

function exception_handler($exception) {
    echo "<strong>Computer sagt nein:</strong><br />";
    echo makePrettyException($exception);
    echo "<br />";
    debug_print_backtrace();
}

set_exception_handler('exception_handler');

new Application('app.ini');