<?php

class Admin_Form_Guia extends Twitter_Form
{
    
    protected $exibir;
    protected $tipo;
    protected $usr;

    public function __construct($tipo = null, $usr = null, $options = null) {
        $this->tipo = strtoupper($tipo);
        $this->usr = $usr;
        
        if ( strtoupper($tipo)=='EDIT' OR strtoupper($tipo)=='NEW'){
            $this->exibir = null;
        }else if ( strtoupper($tipo) == 'SHOW' ){
            $this->exibir = true;
        }
        parent::__construct($options);
    }

    public function init()
    {
        
        $this->setMethod('post');
        $this->setAttrib('horizontal', true);
        /* Form Elements & Other Definitions Here ... */
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome do Guia')
                ->setRequired('true')
                ->setAttrib('autocomplete', 'off')
                ->setAttrib('disabled', $this->exibir)
                ->setValidators( array(
                     array('notEmpty', true, array(
                         'messages' => array(
                             'isEmpty' => 'O nome do grupo não pode ser nulo'
                         )
                     ))
               ));
        
        $arquivo = new Zend_Form_Element_File('thumb');
        $arquivo->setLabel('Miniatura')
                ->setRequired('true')
                ->addValidator('Count', false, 1)
                ->addValidator('Size',false,5502400)
                ->addValidator('Extension',false,'jpg,png,gif'); 
        
        $id = new Zend_Form_Element_Hidden('idCategoria');
        
        $submit = new Zend_Form_Element_Submit('Enviar');
        
        $this->addElements( array(
            $id,
            $nome,
        ));
        
        if ( $this->tipo == 'NEW'){
            $this->addElement($arquivo);
        }
        
        if ( $this->tipo != 'SHOW' ){
            $this->addElement($submit);
        }
    }


}

