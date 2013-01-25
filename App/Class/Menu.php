<?php

class Menu extends Base
{

    // Attribute
    protected $actions = null;
    protected $menuString = '';
    protected $view;
    protected $partialsPath;
    protected static $instance;

    // Methoden

    public function __construct()
    {
        $this->view = new Clix\ClixView();
        $this->view->setScriptsPath('./App/private/views/partials/menu');
    }


    public function getMenu()
    {

        $xmlConfig = simplexml_load_file(ROOT . '/web.config');
        foreach($xmlConfig->menu->link as $menuItem) {
            $attributes = (array)$menuItem;
            $attributes = array_shift($attributes);

            $_menuItem = new StdClass();
            $_menuItem->href = $attributes['href'];
            $_menuItem->text = $attributes['text'];

            if(isset($menuItem->link)) {

                $submenu = new Clix\ClixView();
                $submenu->setScriptsPath('./App/private/views/partials/menu');

                foreach($menuItem->link as $submenuItem) {
                    $attributes = (array)$submenuItem;
                    $attributes = array_shift($attributes);

                    $_submenu = new StdClass();
                    $_submenu->href = $attributes['href'];
                    $_submenu->text = $attributes['text'];

                    $submenu->menu[] = $_submenu;
                }

                $_menuItem->hasSubmenu = true;
                $_menuItem->submenu = $submenu->render('submenu.phtml');

            } else {
                $menuItem->hasSubmenu = false;
            }

            $this->view->menu[] = $_menuItem;
        }

        return $this->view->render('menu.phtml');

    }

}