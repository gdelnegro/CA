<?php

class Admin_ArticleController extends Zend_Controller_Action
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
        $bdArtigos = new Application_Model_DbTable_Artigo();
        $artigos = $bdArtigos->pesquisarArtigo();
        
        $paginator = Zend_Paginator::factory($artigos);
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
        
        $titulo = urldecode( $this->_getParam('titulo') );
        $titulo = str_replace(' ', '_',$titulo);
                
        $dbArtigos = new Application_Model_DbTable_Artigo();
        
        $formMateria = new Admin_Form_Materia('new');
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            
            if ( $formMateria->isValid($data) ){                
                $bdImagem = new Application_Model_DbTable_Imagens();
        
                /*Faz upload do arquivo*/
                $upload = new Zend_File_Transfer_Adapter_Http();
                foreach ($upload->getFileInfo() as $file => $info) {                                     
                    $extension = pathinfo($info['name'], PATHINFO_EXTENSION); 
                    $upload->addFilter('Rename', array( 'target' => APPLICATION_PATH.'/../public/images/artigo/'.$titulo.'.'.$extension,'overwrite' => true,));
                }
            try {
                $upload->receive();
                } catch (Zend_File_Transfer_Exception $e) {
                    echo $e->getMessage();
                }
        
                /*Adicionar dados no banco de dados*/
        
                $dados =array(
                    'descricao'  =>   'Logotipo'.$this->_getParam('sponsor'),
                    'nome'      =>  $titulo.'.'.$extension,
                    'local'     =>  '/images/artigo/',
                    'categoria' =>  '2'
                );
        
                $idImagem = $bdImagem->incluirImagem($dados);        
                       
                $dbArtigos->incluirArtigo($data, $idImagem, $usr);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'article'), null, true);
                #$this->view->dados = $data;
                
            }else{
                $this->view->erro='Dados Invalidos';
                $this->view->formMateria = $formMateria->populate($data);
            }
        }
        $this->view->formMateria = $formMateria;
    }
    
    public function editAction(){
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $usr = ($user->idUsuario);
        
        
        $dbMateria = new Application_Model_DbTable_Artigo();
        $dadosMateria = $dbMateria->pesquisarArtigo( $this->_getParam('id') );
        $formMateria = new Admin_Form_Materia('edit');
        
        $this->view->formMateria = $formMateria->populate($dadosMateria);
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            
            if ( $formMateria->isValid($data) ){
                $this->view->dados = $data;
                $dbMateria->updateArtigo($data, $usr);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'article'), null, true);
            }
        }
    }
}