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
        #$dadosImagens = $dbImagens->pesquisarImagem();
        
        $where = 'categoria = 1';
        $dadosImagens = $dbImagens->pesquisarImagem(null, $where);
        
        $this->view->dadosImagens = $dadosImagens;
        
        $dbNoticias = new Application_Model_DbTable_Artigo();
        $dadosNoticias = $dbNoticias->pesquisarArtigo(null,'revista = 0');
        $dadosEditoriais = $dbNoticias->pesquisarArtigo(null,'revista != 0');
        
        $this->view->dadosNoticias = $dadosNoticias;
        $this->view->dadosEditoriais = $dadosEditoriais;
        
        $dbGuia = Zend_Db_Table::getDefaultAdapter();
        $select = $dbGuia->select()
             ->from('guiaImagem');

        $dadosGuias = $select->query()->fetchAll();
        
        $this->view->dadosGuias = $dadosGuias;
                
    }


}

