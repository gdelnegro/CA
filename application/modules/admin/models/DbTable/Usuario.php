<?php

class Admin_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuarios';
    protected $_primary = 'idUsuario';
    
    
    public function pesquisarUsuario($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirUsuario(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'login'         =>  $request['login'],
            'senha'         =>  md5( $request['senha'] ),
            'email'         =>  $request['email'],
            'nome'          =>  $request['nome'],
            'grupo'         =>  $request['grupo'],
            'dtInclusao'    =>  $date,
            'usrAlterou'    =>  $usr,
            'status'        =>  $request['status'],
            
        );
        
        /*Validação antes da inserção*/
        #$valida =  $this->validaUsr($request,'login');
        
        #return $valida;
        
        try {
            $this->insert($dados);
            return 'ok';
        } catch (Zend_Db_Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function alterarUsuario(array $request, $usr,$oldPass){
        $date = Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss');
        $senha = $request['senha'];
        if( $senha == '' OR md5($senha) == $oldPass){
            $senha = $oldPass;
        }else{
            $senha = md5($senha);
        }
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'login'         =>  $request['login'],
            'senha'         =>  $senha,
            'email'         =>  $request['email'],
            'nome'          =>  $request['nome'],
            'grupo'         =>  $request['grupo'],
            'dtInclusao'    =>  $date,
            'usrAlterou'    =>  $usr,
            'status'        =>  $request['status'],
            
        );
        
        /*Validação antes da inserção*/
        #$valida =  $this->validaUsr($request,'login');
        
        #return $valida;
        $where = $this->getAdapter()->quoteInto("idUsuario = ?", $request['idUsuario']);        
        try {
            $this->update($dados, $where);
            return 'ok';
        } catch (Zend_Db_Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    public function getListaUsuario(){
        $select = $this->_db->select()
                ->from($this->_name, array('key'=>'idUsuario','value'=>'nome'));
        $result = $this->getAdapter()->fetchAll($select);
        
        return $result;
    }


}

