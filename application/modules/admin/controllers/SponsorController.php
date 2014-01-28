<?php

class Admin_SponsorController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $formImagem = new Admin_Form_Imagens();
        $this->view->formImagem = $formImagem;
    }
    
    public function uploadAction()
    {
        $titulo = $this->_getParam('nome');
        
        /*Faz upload do arquivo*/
        $upload = new Zend_File_Transfer_Adapter_Http();
        $upload->addFilter('Rename',APPLICATION_PATH.'/../public/images/sponsor/'.$titulo.'.jpg' );
        $upload->receive();

        /*Adicionar dados no banco de dados*/
        
    }

}