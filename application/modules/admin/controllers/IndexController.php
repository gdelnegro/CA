<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $formulario = new OPI_Formulario();
        $formulario->setCaptionFormulario('Formulário de Testes');
        $formulario->setTipoFormulario('GRID');
    }


}

