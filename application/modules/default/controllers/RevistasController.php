<?php

class Default_RevistasController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $dbRevista = new Application_Model_DbTable_Revistas();
        $dadosRevista = $dbRevista->pesquisarRevista();
        
        $this->view->dadosRevista = $dadosRevista;
    }


}

