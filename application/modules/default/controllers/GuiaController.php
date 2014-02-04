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
    
    public function showAction()
    {
        $id = $this->_getParam('id');
        $dbGuia = new Application_Model_DbTable_Guia();
        $dadosGuia = $dbGuia->pesquisarGuia($id);
        $this->view->logoGuia = $dadosGuia['thumb'];
        $this->view->tituloGuia = $dadosGuia['nome'];
        
        $dbSponsor = new Admin_Model_DbTable_Sponsor('guia');
        $where = "categoria = $id";
        $dadosSponsor = $dbSponsor->pesquisarSponsor(null,$where);
        
        $this->view->dadosSponsor = $dadosSponsor;
    }
    


}

