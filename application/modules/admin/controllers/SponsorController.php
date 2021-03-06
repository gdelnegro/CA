<?php

class Admin_SponsorController extends Zend_Controller_Action
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
        $bdImagens = new Admin_Model_DbTable_Sponsor('sponsor');
        $dadosImagens = $bdImagens->pesquisarSponsor();
        
        $paginator = Zend_Paginator::factory($dadosImagens);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
        $this->view->dados = $dadosImagens;
    }
    
    
    public function testeAction()
    {
        $this->view->dados = $this->getAllParams();
    }
    
    public function uploadAction()
    {
        $titulo = urldecode( $this->_getParam('sponsor') );
        $titulo = str_replace(' ', '_',$titulo);
        $dbImagens = new Application_Model_DbTable_Imagens();
        
        /*Faz upload do arquivo*/
        $upload = new Zend_File_Transfer_Adapter_Http();
        
        foreach ($upload->getFileInfo() as $file => $info) {                                     
            $extension = pathinfo($info['name'], PATHINFO_EXTENSION); 
            $upload->addFilter('Rename', array( 'target' => APPLICATION_PATH.'/../public/images/parceiro/'.$titulo.'.'.$extension,'overwrite' => true,));
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
          'descricao'  =>   'Logotipo'.$this->_getParam('sponsor'),
            'nome'      =>  $titulo.'.'.$extension,
            'local'     =>  '/images/parceiro/',
            'categoria' =>  '1',
        );
        
        $idImagem = $dbImagens->incluirImagem($dados);        
        
        $dadosSponsor = $this->getAllParams();
        $dbSponsor = new Admin_Model_DbTable_Sponsor('patrocinador');
        $dbSponsor->incluirSponsor($dadosSponsor, $idImagem);
        #$this->view->dados = $extension;
        return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'sponsor'), null, true);
    }
    
    public function newAction()
    {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $usr = ($user->idUsuario);
        
        $titulo = urldecode( $this->_getParam('nome') );
        $titulo = str_replace(' ', '_',$titulo);
        
        $formSponsor = new Admin_Form_Sponsor('new');
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            
            if ( $formSponsor->isValid($data) ){                
                $dbSponsor = new Admin_Model_DbTable_Sponsor('patrocinador');
                $bdImagem = new Application_Model_DbTable_Imagens();
        
                $upload = new Zend_File_Transfer_Adapter_Http();
                foreach ($upload->getFileInfo() as $file => $info) {                                     
                    $extension = pathinfo($info['name'], PATHINFO_EXTENSION); 
                    $upload->addFilter('Rename', array( 'target' => APPLICATION_PATH.'/../public/images/parceiros/'.$titulo.'.'.$extension,'overwrite' => true,));
                }
            try {
                $upload->receive();
                } catch (Zend_File_Transfer_Exception $e) {
                    echo $e->getMessage();
                }
        
        
                $dados =array(
                    'descricao'  =>   'Logotipo'.$this->_getParam('sponsor'),
                    'nome'      =>  $titulo.'.'.$extension,
                    'local'     =>  '/images/parceiros/',
                    'categoria' =>  '1',
                );
        
                $idImagem = $bdImagem->incluirImagem($dados);        
                       
                $dbSponsor->incluirSponsor($data, $idImagem, $usr);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'sponsor'), null, true);

                #$this->view->dados = $data;
                
            }else{
                $this->view->erro='Dados Invalidos';
                $this->view->formSponsor = $formSponsor->populate($data);
            }
        }
        $this->view->formSponsor = $formSponsor;
    }
    
    public function editAction()
    {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $usr = ($user->idUsuario);
        
        $dbSponsor = new Admin_Model_DbTable_Sponsor('patrocinador');
        $dadosSponsor = $dbSponsor->pesquisarSponsor( $this->_getParam('id') );
        $formSponsor = new Admin_Form_Sponsor('edit');
        $formSponsor->populate($dadosSponsor);
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            
            if ( $formSponsor->isValid($data) ){                
                $idImagem = $dadosSponsor['logo'];
                $dbSponsor->alterarSponsor($data, $idImagem, $usr);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'sponsor'), null, true);
                #$this->view->data = $data;
                
            }else{
                $this->view->erro='Dados Invalidos';
                $this->view->formSponsor = $formSponsor->populate($data);
            }
        }
        $this->view->dados = $dadosSponsor;
        $this->view->formSponsor = $formSponsor;
    }

}