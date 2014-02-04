<?php

class Default_NoticiasController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $dbNoticias = new Application_Model_DbTable_Artigo();
        $noticias = $dbNoticias->pesquisarArtigo(null);
        
        $this->view->noticias = $noticias;
    }
    
    public function showAction(){
        $dbNoticias = new Application_Model_DbTable_Artigo();
        $dadosNoticias = $dbNoticias->pesquisarArtigo();
        $noticias = $dbNoticias->pesquisarArtigo( $this->_getParam('id') );
        $this->view->noticia = $noticias;
        $this->view->dadosNoticias = $dadosNoticias;
    }


}

