<?php

class Admin_ProgramasController extends Zend_Controller_Action
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
        // action body
        $dbProgramas = new Application_Model_DbTable_Programas();
        $dados = $dbProgramas->pesquisarPrograma();
        
        $paginator = Zend_Paginator::factory($dados);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
    }
    
    public function newAction()
    {
        $formPrograma = new Admin_Form_Programas('new');
        
        if( $this->getRequest()->isPost() ) {
            $dadosPrograma = $this->getRequest()->getPost();
            
            if ( $formPrograma->isValid($dadosPrograma) ){                
                $dbPrograma = new Application_Model_DbTable_Programas();
                $dbPrograma->incluirPrograma($dadosPrograma);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'programas'), null, true);
                
            }else{
                $this->view->erro='Dados Invalidos';
                $this->view->formPrograma = $formPrograma->populate($dadosPrograma);
            }
        }
        $this->view->formPrograma = $formPrograma;
    }
    
    public function showAction(){
        
       $formPrograma = new Admin_Form_Programas('show');
       $bdPrograma = new Default_Model_DbTable_Programas();
        
       $dadosPrograma = $bdPrograma->pesquisarPrograma( $this->_getParam('id'));
        
       $formPrograma->populate($dadosPrograma);
        
       $this->view->formPrograma = $formPrograma;
    }
   
   public function editAction(){
              
       $formProgramas = new Admin_Form_Programas('edit');
       $bdProgramas = new Default_Model_DbTable_Programas();
        
       $dadosProgramas = $bdProgramas->pesquisarPrograma( $this->_getParam('id'));
        
       $formProgramas->populate($dadosProgramas);
        
       $this->view->formProgramas = $formProgramas;
   }
   
   public function updateAction()
   {
       $usuario = Zend_Auth::getInstance()->getIdentity();
       
       $bdProgramas = new Default_Model_DbTable_Programas();
       
       $bdProgramas->alterarPrograma( $this->_getAllParams(), $usuario->idUsr );
       
       $this->_helper->redirector('index');
   }
   
   public function deleteAction()
   {
       $id = $this->_getParam('id');
       $dao = new Application_Model_DbTable_Programas();
       $where = $dao->getAdapter()->quoteInto("idPrograma = ?", $id);
       $dao->delete($where);

       return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'programas'), null, true);
   }


}

