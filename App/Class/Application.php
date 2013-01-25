<?php

class Application extends Clix\Clix
{

    // Attribute
    protected $pageTitle = array();

    // Methoden

    public function init()
    {
        parent::init();
        $this->view->menu = Menu::getSingleton()->getMenu();
        $this->view->baseHref = $this->config['clix']['baseHref'];
        $this->view->projectName = $this->config['clix']['projectName'];
        $this->pageTitle[] = $this->config['clix']['projectName'];
    }

    /*** Actions ***/
    /* Zu jeder Action gehört ein Template,
       zu finden in views/ mit dem Namen
       der Action (Bsp: index.phtml) */

    public function indexAction()
    {
        $this->setPageTitle('Startseite');
    }

    public function testAction()
    {
        $this->setPageTitle('Testseite');

        $test = new Model\PunktModel();
        $test->loadById(2);

        $test->set(
            array(
                'GeoPosX' => 8,
                'GeoPosY' => 16,
                'Info'    => 'Messpunkt'
            )
        )->save();

        Debug::print_r($test);
    }

    protected function setPageTitle($suffix = '')
    {
        if(!empty($suffix))
            $this->pageTitle[] = $suffix;

        $this->view->pageTitle = implode(" | ", $this->pageTitle);
    }

}