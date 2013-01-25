<?php

namespace Clix;

class ClixView
{
    protected $_scriptsPath = '';
    protected $_layout = '';
    protected $_render = 0;

    public function render($file)
    {
        $this->_render++;

        if (!$this->exists($file)) {
            //file_put_contents($this->_scriptsPath . $file, '<div class="alert alert-error">Diese View wurde gerade automatisch angelegt.</div>');
            throw new ClixViewException("View file not found '{$file}'. (script path: {$this->_scriptsPath})");
        }

        ob_start();
        include("{$this->_scriptsPath}{$file}");
        $content = ob_get_clean();

        if (($this->_render==1)and(!empty($this->_layout))) {
            $this->_content = $content;
            $content = $this->render($this->_layout);
        }

        return $content;
    }

    public function exists($file)
    {
        return file_exists("{$this->_scriptsPath}{$file}");
    }

    public function setScriptsPath($path)
    {
        if ($path[strlen($path-1)]!='/') {
            $path .= '/';
        }
        $this->_scriptsPath = $path;
    }

    public function setLayout($file)
    {
        if ($this->exists($file)) {
            $this->_layout = $file;
        } else {
            throw new ClixViewException("Layout file not found '{$file}'. (script path: {$this->_scriptsPath})");
        }
    }
}
