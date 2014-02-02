<?php

class Application_Model_DbTable_Guia extends Zend_Db_Table_Abstract
{

    protected $_name = 'categoriaGuia';
    protected $_primary = 'idCategoria';
    
    public function pesquisarGuia($id = null, $where = null, $order = null, $limit = null){
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
    
    public function getListaGuia(){
        $select = $this->_db->select()
                ->from($this->_name, array('key'=>'idCategoria','value'=>'nome'));
        $result = $this->getAdapter()->fetchAll($select);
        
        return $result;
    }


}

