<?php

class Default_GuiaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $dbGuia = new Application_Model_DbTable_Guia();
        $dadosGuia = $dbGuia->pesquisarGuia();
        
        $this->view->dados = $dadosGuia;
    }
    


}

