<?php

class Admin_Form_Materia extends Zend_Form
{

    public function init()
    {
        $idMateria = new Zend_Form_Element_Hidden('idMateria');
        $titulo = new Zend_Form_Element_Text('titulo');
        $descricao = new Zend_Form_Element_Textarea('descricao');
        $texto = new Zend_Form_Element_Textarea('texto');
        $tag;
        
        $this->addElements( array(
            $idMateria,
            $titulo,
            $descricao,
            $texto,
        ));
        
    }


}

