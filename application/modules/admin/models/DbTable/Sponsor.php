<?php

class Admin_Model_DbTable_Sponsor extends Zend_Db_Table_Abstract
{

    protected $_name = 'patrocinador';
    protected $_primary = 'idPatrocinador';
    
    
    public function __construct($nome = null,$options = null) {
        if( !is_null($nome) ){
            $this->_name = $nome;
        }elseif (is_null($nome)) {
            $this->_name = 'patrocinador';
        }
        
        
        parent::__construct($options);
    }

    public function pesquisarSponsor($id = null, $where = null, $order = null, $limit = null){
        if( !is_null($id) ){
            $arr = $this->find($id)->toArray();
            return $arr[0];
        }else{
            $select = $this->select()->from($this)->order($order)->limit($limit);
            if(!is_null($where)){
                $select->where($where);
            }
            return $this->fetchAll($select)->toArray();
        }
    }
    
    
    /**
     * 
     * @param array $request dados que serão enviados ao BD
     * @return inserção dos dados no BD
     */
    public function incluirSponsor(array $request, $idImagem, $usr){
        
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'nome' => $request['nome'],
            'categoria' => $request['categoria'],
            'logo' => $idImagem,
            'dtInclusao' => $date,
            'usrCriou' => $usr,
            'site' => $request['site'],
            'email' => $request['email'],
            'endereco' => $request['endereco'],
            'cidade' => $request['cidade'],
            'estado' => $request['estado'],
            'tipo' => $request['tipo'],
            'cep' => $request['cep'],
            'telefone' => $request['telefone'],
            
        );
        return $this->insert($dados);
    }
    
    public function alterarSponsor(array $request, $idImagem, $usr){
        
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'nome' => $request['nome'],
            'categoria' => $request['categoria'],
            'logo' => $idImagem,
            'dtInclusao' => $date,
            'usrCriou' => $usr,
            'site' => $request['site'],
            'email' => $request['email'],
            'endereco' => $request['endereco'],
            'cidade' => $request['cidade'],
            'estado' => $request['estado'],
            'tipo' => $request['tipo'],
            'cep' => $request['cep'],
            'telefone' => $request['telefone'],
            
        );
        
        $where = $this->getAdapter()->quoteInto("idPatrocinador = ?", $request['idPatrocinador']);
        $this->update($dados, $where);
    }
    
    
    public function getListaSponsor(){
        $select = $this->_db->select()
                ->from($this->_name, array('key'=>'idPatrocinador','value'=>'nome'));
        $result = $this->getAdapter()->fetchAll($select);
        
        return $result;
    }


}