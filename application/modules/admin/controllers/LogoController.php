<?php

class Admin_LogoController extends Zend_Controller_Action
{

    public function init()
    {
        $usuario = Zend_Auth::getInstance()->getIdentity();
        Zend_Layout::getMvcInstance()->assign('usuario', $usuario);
        
        if ( !Zend_Auth::getInstance()->hasIdentity() ) {
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'index'), null, true);
        }
    }

    public function indexAction()
    {
        $bdLogo = new Application_Model_DbTable_Logo();
        $logo = $bdLogo->pesquisarLogo();
        
        $paginator = Zend_Paginator::factory($logo);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
    }
    
    public function editAction()
    {
        $formLogo = new Admin_Form_Logo();
        
        $this->view->formLogo = $formLogo;
    }


}

