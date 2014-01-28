<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->statusSite = 'Tendências';
    }

    public function indexAction()
    {
        // action body
        
        $dbProgramas = new Application_Model_DbTable_Programas();
        $dadosProgramas = $dbProgramas->pesquisarPrograma();
        
        $this->view->dadosProgramas = $dadosProgramas;
        
        $dbImagens = new Application_Model_DbTable_Imagens();
        $dadosImagens = $dbImagens->pesquisarImagem();
        
        $this->view->dadosImagens = $dadosImagens;
                
    }


}

