<?php

class Default_ParceiroController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = $this->_getParam('id');
        
        $dbSponsor = new Admin_Model_DbTable_Sponsor();
        $dadosSponsor = $dbSponsor->pesquisarSponsor($id);
        
        $this->view->dados = $dadosSponsor;
    }


}

