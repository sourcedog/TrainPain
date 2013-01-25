<?php

/**
 * Clix Framework
 *
 * version: 1.0
 * author: Petr Kratina <petr.kratina@gmail.com>
 * licence: New BSD Licence http://www.opensource.org/licenses/bsd-license.php
 * homepage: http://clix.red-pill.cz/
 * project: http://code.google.com/p/clix-framework/
 **/

namespace Clix;

class Clix
{
    protected $view;
    protected $config;
    protected $uri;
    protected $params;
    protected $raw;
    protected $db;
    protected $actionTemplate;

    public function __construct($config = null, $run = true)
    {
        $this->view = new ClixView();
        $this->view->setScriptsPath('./App/private/views');

        $this->config = ClixConfig::getSingleton()->getData();

        $this->view->config = $this->config['clix'];

        if (!empty($this->config['mysql'])) {
            $this->db = ClixMySQL::getSingleton();
        }

        if (!empty($this->config['clix']['layout'])) {
            if (($this->config['clix']['layout']=='1')or
                ($this->config['clix']['layout']=='true')) {
                $this->view->setLayout('layout.phtml');
            } else {
                $this->view->setLayout($this->config['clix']['layout']);
            }
        } elseif ($this->view->exists('layout.phtml')) {
            $this->config['clix']['layout'] = 'layout.phtml';
            $this->view->setLayout('layout.phtml');
        }

        $urifilter = array(
            "/^" . preg_quote($this->config['clix']['base'], '/') . "/i", // remove base uri
            "/^\/+/", // remove first slashes
            "/\/+$/" // remove last slashes
        );

        $this->uri = preg_replace($urifilter, '', $_SERVER['REQUEST_URI']);

        $this->params = explode('/', $this->uri);
        if (empty($this->params[0])) {
            $this->params[0] = 'index';
        }
        $this->raw = $this->params;
        $this->params[0] = strtolower($this->params[0]);

        $this->init();

        if ($run) {
            $this->run();
        }
    }

    public function _getParam($index, $raw = false)
    {
        $p = $this->params;
        if ($raw) {
            $p = $this->raw;
        }
        if (isset($p[$index])) {
            return $p[$index];
        }
        return false;
    }

    public function init() { }

    public function run()
    {
        $action = $this->camel("{$this->params[0]}Action");
        $view = strtolower(implode('/', $this->params) . '.phtml');
        if (method_exists($this, $action)) {
            $this->actionTemplate = $this->params[0] . '.phtml';
            $this->$action();
            echo $this->view->render($this->actionTemplate);
        } elseif ($this->view->exists($view)) {
            echo $this->view->render($view);
        } elseif (method_exists($this, 'defaultAction')) {
            $action = 'defaultAction';
            $this->actionTemplate = 'default.phtml';
            $this->$action();
            echo $this->view->render($this->actionTemplate);
        } else {
            $this->errorAction();
            echo $this->view->render('error.phtml');
        }
    }

    public function camel($text)
    {
        $r = '';
        for ($i = 0; $i < strlen($text); $i++) {
            if ($text[$i]=='-') {
                $i++;
                $r .= strtoupper($text[$i]);
            } else {
                $r .= $text[$i];
            }
        }
        return $r;
    }

    public function errorAction()
    {
        header("HTTP/1.0 404 Not Found");
    }

    public function _redirect($url)
    {
        if (!preg_match("/^http/i", $url)) {
            header("Location: {$this->config['clix']['base']}{$url}");
        } else {
            header("Location: {$url}");
        }
        exit;
    }
}
