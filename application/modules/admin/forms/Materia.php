<?php

class Admin_Form_Materia extends Twitter_Form
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
        $idMateria = new Zend_Form_Element_Hidden('idMateria');
        
        $titulo = new Zend_Form_Element_Text('titulo');
        $titulo->setLabel('Titulo da Matéria');
        $titulo->setRequired(true)
                ->setFilters(array('StringTrim'))
                ->setValidators( array(
                     array('notEmpty', true, array(
                         'messages' => array(
                             'isEmpty' => 'O título da matéria não pode ser nulo'
                         )
                     ))
               ))
                ->setAttrib('disabled', $this->exibir);
        
        $descricao = new Zend_Form_Element_Textarea('descricao');
        $descricao->setLabel('Resumo da Matéria')
                ->setRequired(true)
                ->setFilters(array('StringTrim'))
                ->setValidators( array(
                     array('notEmpty', true, array(
                         'messages' => array(
                             'isEmpty' => 'A descrição da matéria não pode ser nula'
                         )
                     ))
               ))
                ->setAttrib('disabled', $this->exibir);
        
        $texto = new Zend_Form_Element_Textarea('texto');
        $texto->setLabel('Texto da Matéria')   
                ->setRequired(true)
                ->setFilters(array('StringTrim'))
                ->setValidators( array(
                     array('notEmpty', true, array(
                         'messages' => array(
                             'isEmpty' => 'O texto da matéria não pode ser nulo'
                         )
                     ))
               ))
                ->setAttrib('disabled', $this->exibir);
        
        $arquivo = new Zend_Form_Element_File('thumb');
        $arquivo->setLabel('Miniatura')
                ->setRequired('true')
                ->addValidator('Count', false, 1)
                ->addValidator('Size',false,5502400)
                ->addValidator('Extension',false,'jpg,png,gif');        
        
        $dbSponsor = new Admin_Model_DbTable_Sponsor();
        $listaSponsor = $dbSponsor->getListaSponsor();
        
        $sponsor = new Zend_Form_Element_Select('sponsor');
        $sponsor->setLabel('Patrocinador')
                ->addMultiOptions(
                        array('0'=>'Sem Patrocinador')
                )
                ->addMultiOptions($listaSponsor);
        #$tag;
        
        $dbRevista = new Application_Model_DbTable_Revistas();
        $listaRevistas = $dbRevista->getListaRevista();
        
        $revista = new Zend_Form_Element_Select('revista');
        $revista->setLabel('Revista:')
                ->addMultiOptions(array('0'=>'Escolha uma revista'))
                ->addMultiOptions($listaRevistas);

        $submit = new Zend_Form_Element_Submit('Enviar');
        
        if( $this->tipo == 'NEW' or $this->tipo == 'SHOW'){
            $this->addElements( array(
                $idMateria,
                $titulo,
                $descricao,
                $texto,
                $sponsor,
                $arquivo,
                $revista
            ));
            
        }elseif ( $this->tipo == 'EDIT' ) {
            
            $this->addElements(array(
                $idMateria,
                $texto,
                $revista,
                $submit
            ));
            
        }
        
        if ($this->tipo != 'SHOW' AND $this->tipo != 'EDIT') {
            
            $this->addElements(array($idMateria,$arquivo,$submit));
            
        }
        
        if ( $this->tipo == 'SHOW' ) {
            
            $this->addElement("button", "imprimir", array(
                            "class" => "btn-primary",
                            "label" => "Imprimir",
                            "onclick" => 'window.print()',
                    ));
        }
    }
}