<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->statusSite = 'Tendências';
    }

    public function indexAction()
    {
        // action body
    }


}

