<?php

class Application_Model_DbTable_Logo extends Zend_Db_Table_Abstract
{

    protected $_name = 'logo';
    protected $_primary = 'diretorio';
    
    public function pesquisarLogo($id = null, $where = null, $order = null, $limit = null){
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
    
     public function alterarLogo($cor){
        $date = Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss');
        
        $dados = array(
            'corFundo' => $cor,
            'dtAlteracao' => $date,
        );
        #$where = $this->getAdapter()->quoteInto("idPrograma = ?", $request['idPrograma']);
        $this->update($dados, $where);
     }


}

