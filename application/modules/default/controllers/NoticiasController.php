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
        $noticias = $dbNoticias->pesquisarArtigo();
        
        $this->view->noticias = $noticias;
    }


}
