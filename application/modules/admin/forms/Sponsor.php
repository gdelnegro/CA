<?php

class Admin_Form_Sponsor extends Twitter_Form
{
    
    protected $exibir;
    protected $_tipo;
    protected $usr;

    public function __construct($tipo = null, $usr = null, $options = null) {
        $this->_tipo = strtoupper($tipo);
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
        $idPatrocinador = new Zend_Form_Element_Hidden('idPatrocinador');
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome')
                ->setRequired('true')
                ->setValidators( array(
                     array('notEmpty', true, array(
                         'messages' => array(
                             'isEmpty' => 'O nome do parceiro não pode ser nulo'
                         )
                     ))
               ))
                ->setAttrib('disabled', $this->exibir);
        
        $arquivo = new Zend_Form_Element_File('arquivo');
        $arquivo->setLabel('Logotipo')
                ->setRequired('true')
                ->addValidator('Count', false, 1)
                ->addValidator('Size',false,5502400)
                ->addValidator('Extension',false,'jpg,png,gif');
        
        $dbGuia = new Application_Model_DbTable_Guia();
        $listaGuia = $dbGuia->getListaGuia();
        
        $categoria = new Zend_Form_Element_Select('categoria');
        $categoria->setLabel('Categoria do Guia')
                ->setRequired(true)
                ->addMultiOptions($listaGuia);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
                ->setAttrib('disabled', $this->exibir);
        
        $cep = new Zend_Form_Element_Text('cep');
        $cep->setLabel('CEP')
                ->setAttrib('disabled', $this->exibir);
        
        $telefone = new Zend_Form_Element_Text('telefone');
        $telefone->setLabel('Telefone')
                ->setAttrib('disabled', $this->exibir);
        
        $site = new Zend_Form_Element_Text('site');
        $site->setLabel('Site')
                ->setAttrib('disabled', $this->exibir);
       
        $endereco = new Zend_Form_Element_Text('endereco');
        $endereco->setLabel('Endereco')
                ->setAttrib('disabled', $this->exibir);
        
        $cidade = new Zend_Form_Element_Text('cidade');
        $cidade->setLabel('Cidade')
                ->setAttrib('disabled', $this->exibir);
        
        $estado = new Zend_Form_Element_Text('estado');
        $estado->setLabel('Estado')
                ->setAttrib('disabled', $this->exibir);
        
        $tipoSponsor = new Zend_Form_Element_Select('tipo');
        $tipoSponsor->setLabel('Tipo de patrocinador')
                ->addMultiOptions(array(
                   'empresa' => 'Pessoa Juridica',
                    'pessoa'    =>  'Pessoa Física'
                ));
        
        $submit = new Zend_Form_Element_Submit('Enviar');
        
        $this->addElements(array(
            $idPatrocinador,
            $nome,
        ));
        
        if( $this->_tipo == 'NEW'){
            $this->addElement($arquivo);
        }
        
        $this->addElements(array(
            $categoria,
            $tipoSponsor,
            $email,
            $endereco,
            $cidade,
            $estado,
            $cep,
            $telefone,
            $site
        ));
        
        
        if ( $this->_tipo != 'SHOW'){
            $this->addElement($submit);
        }
        
        
        
        
    }


}

