<?php

class Application_Model_DbTable_Programas extends Zend_Db_Table_Abstract
{

    protected $_name = 'programas';
    protected $_primary = 'idPrograma';
    
    public function pesquisarPrograma($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirPrograma(array $request){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        if ( strlen($request['url']) > 12 ){
            parse_str( parse_url( $request['url'], PHP_URL_QUERY ), $my_array_of_vars );
            $url = $my_array_of_vars['v'];
        }else{
            $url = $request['url'];
        }
        
        
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'titulo' => $request['titulo'],
            'descricao' => $request['descricao'],
            'url' => $url,
            'dtAlteracao' => $date,
        );
        return $this->insert($dados);
    }
    
    public function alterarPrograma(array $request){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        if ( strlen($request['url']) > 12 ){
            parse_str( parse_url( $request['url'], PHP_URL_QUERY ), $my_array_of_vars );
            $url = $my_array_of_vars['v'];
        }else{
            $url = $request['url'];
        }
        
        
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'titulo' => $request['titulo'],
            'descricao' => $request['descricao'],
            'url' => $url,
            'dtInclusao' => $date,
        );
        $where = $this->getAdapter()->quoteInto("idPrograma = ?", $request['idPrograma']);
        $this->update($dados, $where);
    }


}

