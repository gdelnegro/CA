<?php

class Admin_Form_Sponsor extends Twitter_Form
{

    public function init()
    {
        $formImagem = new Admin_Form_Imagens();
        $nome = new Zend_Form_Element_Text('sponsor');
        $nome->setLabel('Nome')
                ->setRequired('true');
        
        $this->addElements(array(
            $nome,
        ));
        
        $this->addSubForm($formImagem, 'teste');
        
        $submit = new Zend_Form_Element_Submit('enviar');
        
        $this->addElement($submit);
    }


}

