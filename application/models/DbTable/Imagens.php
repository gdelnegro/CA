<?php

class Application_Model_DbTable_Imagens extends Zend_Db_Table_Abstract
{

    protected $_name = 'imagens';
    protected $_primary = 'idImagens';
    
    public function pesquisarImagem($id = null, $where = null, $order = null, $limit = null){
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
    public function incluirImagem(array $request, $categoria = null){
        
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'descricao' => $request['descricao'],
            'local' => $request['local'],
            'nome' => $request['nome'],
            'categoria' => $request['categoria']
            
        );
        
        $this->insert($dados);
        
        $lastInsertId = $this->getAdapter()->lastInsertId();
        return  $lastInsertId;
    }
    
    
    public function excluirImagem($id)
   {
      $dao = new Application_Model_DbTable_Imagens();
      $where = $dao->getAdapter()->quoteInto("idImagens = ?", $id);
      $dao->delete($where);
   }

}

