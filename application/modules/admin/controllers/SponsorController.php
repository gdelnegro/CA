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
        $dbImagens = new Admin_Model_DbTable_Imagens();
        
        /*Faz upload do arquivo*/
        $upload = new Zend_File_Transfer_Adapter_Http();
        
        foreach ($upload->getFileInfo() as $file => $info) {                                     
            $extension = pathinfo($info['name'], PATHINFO_EXTENSION); 
            $upload->addFilter('Rename', APPLICATION_PATH.'/../public/images/sponsor-'.$titulo.'.'. $extension, true);
        }
        
        try {
            // This takes care of the moving and making sure the file is there
            $upload->receive();
            // Dump out all the file info
            } catch (Zend_File_Transfer_Exception $e) {
                echo $e->message();
            }
        
        /*Adicionar dados no banco de dados*/
        
        $dados =array(
          'descricao'  =>   $this->_getParam('descricao'),
            'nome'      =>  'sponsor-'.$titulo.'.jpg',
            'local'     =>  APPLICATION_PATH.'/../public/images/',
        );
        
        $dbImagens->incluirImagem($dados);
    }

}