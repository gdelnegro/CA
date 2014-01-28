<?php

class Default_GuiaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $dbImagens = new Application_Model_DbTable_Imagens();
        $dadosImagens = $dbImagens->pesquisarImagem();
        $this->view->dados = $dadosImagens;
    }
    


}

