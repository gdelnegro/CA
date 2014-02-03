<?php

class Admin_Form_MateriaRevista extends Twitter_Form
{

    public function init()
    {
        $dbRevista = new Application_Model_DbTable_Revistas();
        $listaRevistas = $dbRevista->getListaRevista();
        $revista = new Zend_Form_Element_Select('revista');
        $revista->setLabel('Revista')
                ->addMultiOptions($listaRevistas);
        
        $dbArtigos = new Application_Model_DbTable_Artigo();
        $listaArtigos = $dbArtigos->getListaArtigo();
        
        $artigo = new Zend_Form_Element_Radio('artigo');
        $artigo->setLabel('Artigos')
                ->addMultiOptions($listaArtigos);
        
        $this->addElements(array(
            $revista,
            $artigo
        ));
        
    }


}

