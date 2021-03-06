<?php

class Admin_Model_DbTable_Grupo extends Zend_Db_Table_Abstract
{

    protected $_name = 'grupos';
    protected $_primary = 'idGrupo';
    
    
    public function pesquisarGrupo($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirGrupo(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'descricao'      =>  $request['descricao'],
            'dtInclusao'     =>  'NOW()',
            'usrCriou'     =>  $usr,
        );
        return $this->insert($dados);
    }
    
    public function alterarGrupo(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'descricao'      =>  $request['descricao'],
            'dtAlteracao'     =>  $date,
            'usrAlterou'     =>  $usr,
        );
        $where = $this->getAdapter()->quoteInto("idGrupo = ?", $request['idGrupo']);
        $this->update($dados, $where);
    }
    
    public function getListaGrupo(){
        $select = $this->_db->select()
                ->from($this->_name, array('key'=>'idGrupo','value'=>'descricao'));
        $result = $this->getAdapter()->fetchAll($select);
        
        return $result;
    }
}

