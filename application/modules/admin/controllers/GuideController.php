<?php

class Admin_GuideController extends Zend_Controller_Action
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
        $bdGuia = new Application_Model_DbTable_Guia();
        $guia = $bdGuia->pesquisarGuia();
        
        $paginator = Zend_Paginator::factory($guia);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
    }
    
    public function newAction()
    {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $usr = ($user->idUsuario);
        
        $titulo = urldecode( $this->_getParam('nome') );
        $titulo = str_replace(' ', '_',$titulo);
                
        $dbGuia = new Application_Model_DbTable_Guia();
        
        $formGuia = new Admin_Form_Guia();
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            
            if ( $formGuia->isValid($data) ){                
                $bdImagem = new Application_Model_DbTable_Imagens();
        
                /*Faz upload do arquivo*/
                $upload = new Zend_File_Transfer_Adapter_Http();
                foreach ($upload->getFileInfo() as $file => $info) {                                     
                    $extension = pathinfo($info['name'], PATHINFO_EXTENSION); 
                    $upload->addFilter('Rename', array( 'target' => APPLICATION_PATH.'/../public/images/guia-'.$titulo.'.'.$extension,'overwrite' => true,));
                }
            try {
                $upload->receive();
                } catch (Zend_File_Transfer_Exception $e) {
                    echo $e->getMessage();
                }
        
                /*Adicionar dados no banco de dados*/
        
                $dados =array(
                    'descricao'  =>   'Logotipo'.$this->_getParam('sponsor'),
                    'nome'      =>  'guia-'.$titulo.'.'.$extension,
                    'local'     =>  '/images/',
                    'categoria' =>  '3'
                );
        
                $idImagem = $bdImagem->incluirImagem($dados);        
                       
                $dbGuia->incluirGuia($data, $idImagem, $usr);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'guide'), null, true);
                $this->view->dados = $data;
                
            }else{
                $this->view->erro='Dados Invalidos';
                $this->view->formGuia = $formGuia->populate($data);
            }
        }
        $this->view->formGuia = $formGuia;
    }
    
    public function editAction(){
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $usr = ($user->idUsuario);
        
        
        $dbGuia = new Application_Model_DbTable_Guia();
        $dadosGuia = $dbGuia->pesquisarGuia( $this->_getParam('id') );
        $formGuia = new Admin_Form_Guia('edit');
        
        $this->view->formGuia = $formGuia->populate($dadosGuia);
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            
            if ( $formGuia->isValid($data) ){
                $this->view->dados = $data;
                $dbGuia->alterarGuia($data, $usr);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'guide'), null, true);
            }
        }
    }


}

