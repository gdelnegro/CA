<?php

class Admin_Form_Usuario extends Twitter_Form
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
        
        $this->setAttrib('horizontal', true);
        
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome do usuário')
                ->setAttrib('placeholder', 'Nome completo')
                ->setRequired('true')
                ->setAttrib('autocomplete', 'off')
                ->setAttrib('disabled', $this->exibir);
        
        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login')
                ->setAttrib('disabled', $this->exibir)
                ->setAttrib('placeholder', 'Login')
                ->setRequired('true')
                ->setAttrib('autocomplete', 'off');
        
        $senha = new Zend_Form_Element_Password('senha');
        $senha->setLabel('Senha')
                ->setAttrib('disabled', $this->exibir)
                ->setRequired('true')
                ->setAttrib('autocomplete', 'off');
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail')
                ->setAttrib('autocomplete', 'off')
                ->setAttrib('Placeholder', 'Favor digitar e-mail do usuário');
        
        $grupo = new Zend_Form_Element_Text('grupo');
        $grupo->setLabel('Grupo')
                ->setAttrib('disabled', $this->exibir)
                ->setRequired('true')
                ->setAttrib('autocomplete', 'off');
        
        $status = new Zend_Form_Element_Checkbox('status');
        $status->setLabel('Ativo');
        
        $this->addElements( array( 
            $nome,
            $login,
            $senha,
            $email,
            $grupo,
            $status,
        ) );
        
        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit->setAttrib(
        'onclick', 
        'if (confirm("Deseja prosseguir?")) { document.form.submit(); } return false;'
        );
        
        $this->addElement($submit);
        
        $this->addElement("button", "voltar", array(
                        "class" => "btn-primary",
                        "label" => "Voltar",
                        "onclick" => 'window.location =\''.$this->getView()->url(array('module'=>'admin','controller'=>'users','action'=>'index')).'\' '
                ));
    }


}

