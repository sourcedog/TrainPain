<?php

namespace Clix;

class ClixConfig extends \Base
{
    protected static $instance;
    protected $data = array();

    public function __construct()
    {
        $this->data = array(
            'clix' => array(
                'base' => ''
            )
        );

        $this->data = array_merge($this->data, parse_ini_file('app.ini', true));

        if (empty($this->data['clix']['base'])) {
            $this->data['clix']['base'] = preg_replace("/\/index.php/i", '', $_SERVER['SCRIPT_NAME']);
        }
    }

    public function getData()
    {
        return $this->data;
    }

}