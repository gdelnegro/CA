<?php

class Admin_SponsorController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $usuario = Zend_Auth::getInstance()->getIdentity();
        //$this->view->usuario = $usuario;
        Zend_Layout::getMvcInstance()->assign('usuario', $usuario);
        
        if ( !Zend_Auth::getInstance()->hasIdentity() ) {
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'index'), null, true);
            //$this->_redirect('/');
        }
    }

    public function indexAction()
    {
        $bdImagens = new Application_Model_DbTable_Imagens();
        $dadosImagens = $bdImagens->pesquisarImagem();
        
        $paginator = Zend_Paginator::factory($dadosImagens);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
    }
    
    public function uploadAction()
    {
        $titulo = $this->_getParam('nome');
        $dbImagens = new Application_Model_DbTable_Imagens();
        
        /*Faz upload do arquivo*/
        $upload = new Zend_File_Transfer_Adapter_Http();
        
        foreach ($upload->getFileInfo() as $file => $info) {                                     
            $extension = pathinfo($info['name'], PATHINFO_EXTENSION); 
            $upload->addFilter('Rename', APPLICATION_PATH.'/../public/images/sponsor-'.$titulo.'.'. $extension);
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
            'local'     =>  '../public/images/',
        );
        
        $dbImagens->incluirImagem($dados);        
    }
    
    public function newAction()
    {
        $formImagem = new Admin_Form_Imagens();
        $this->view->formImagem = $formImagem;
    }

}