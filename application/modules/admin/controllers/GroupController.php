<?php

class Admin_GroupController extends Zend_Controller_Action
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
        $dbGrupo = new Admin_Model_DbTable_Grupo();
        $dadosGrupo = $dbGrupo->pesquisarGrupo();
        
        $paginator = Zend_Paginator::factory($dadosGrupo);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
    }
    
    public function showAction()
    {
        
    }
    
    public function newAction()
    {
        $formGrupo = new Admin_Form_Grupo();
        $this->view->formGrupo = $formGrupo;
    }
    
    public function createAction()
    {
        
    }
    
    public function editAction()
    {
        $formGrupo = new Admin_Form_Grupo();
        $dbGrupo = new Admin_Model_DbTable_Grupo();
        $dadosGrupo = $dbGrupo->pesquisarGrupo( $this->_getParam('id') );
        $formGrupo->populate( $dadosGrupo );
        
        $this->view->formGrupo = $formGrupo;
    }
   
}

