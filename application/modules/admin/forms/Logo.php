<?php

class Admin_Form_Logo extends Twitter_Form
{

    public function init()
    {
        $cor = new Zend_Form_Element_Text('cor');
        $cor->setLabel('Código de cor do fundo do logo')
                ->setRequired(true)
                ->setAttrib('Placeholder', 'Código da cor');
        
        $submit = new Zend_Form_Element_Submit('Enviar');
        
        $this->addElements( array(
            $cor,
            $submit
        ));
    }


}

