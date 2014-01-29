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
        $date = Zend_Date::now()->toString('yyyy-MM-dd HH:ii:ss');
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
        return $this->insert($dados);
    }


}

