<?php

class Default_ProgramasController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        // action body
        $dbPrograma = new Default_Model_DbTable_Programas();
        $dados = $dbPrograma->pesquisarPrograma();
        
        $this->view->dados = $dados;
        
        
    }


}
