<?php

class Application_Model_DbTable_Revistas extends Zend_Db_Table_Abstract
{

    protected $_name = 'revistas';
    protected $_primary = 'idRevista';
    
    public function pesquisarRevista($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirRevista(array $request, $idImagem, $usr){
        
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'titulo'        =>  $request['titulo'],
            'descricao'     =>  $request['descricao'],
            'edicao'         =>  $request['edicao'],
            'dtInclusao'    =>  $date,
            'capa' => $idImagem,
            'ano'           => $request['ano'],
        );
        
        #try {
           return $this->insert($dados);
        #    return true;
        #} catch (Zend_Db_Exception $exc) {
        #    echo $exc->getMessage();
        #}
    }
    
    public function alterarRevista(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        $dados = array(
            'titulo'        =>  $request['titulo'],
            'descricao'     =>  $request['descricao'],
            'edicao'         =>  $request['edicao'],
            'dtInclusao'    =>  $date,
            'ano'           => $request['ano'],
            'dtAlteracao' => $date,
        );
        $where = $this->getAdapter()->quoteInto("idRevista = ?", $request['idRevista']);
        $this->update($dados, $where);
    }
    
    public function getListaRevista(){
        $select = $this->_db->select()
                ->from($this->_name, array('key'=>'idRevista','value'=>'titulo'));
        $result = $this->getAdapter()->fetchAll($select);
        
        return $result;
    }


}

