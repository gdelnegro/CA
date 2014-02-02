<?php

class Application_Model_DbTable_Artigo extends Zend_Db_Table_Abstract
{

    protected $_name = 'materias';
    protected $_primary = 'idMateria';
    
    public function pesquisarArtigo($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirArtigo(array $request, $idImagem, $usr){
        
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        $sponsor = $request['sponsor'];
        
        if ( $request['sponsor'] == 0 ) {
            $sponsor = null;
        }
        
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'titulo'        =>  $request['titulo'],
            'descricao'     =>  $request['descricao'],
            'texto'         =>  $request['texto'],
            'autor'         =>  $usr,
            'dtInclusao'    =>  $date,
            'patrocinador'  =>  $sponsor,
            'thumb' => $idImagem
        );
        
        try {
           return $this->insert($dados);
            return true;
        } catch (Zend_Db_Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function updateArtigo($request, $usr = null){
        if ( !is_null( $request ) ){
            $where = $this->getAdapter()->quoteInto("idMateria = ?", $request['idMateria']);
            $dados = array(
                'texto' =>  $request['texto']
            );
            
            $this->update($dados, $where);
        }else{
            echo 'Não foram passados dados para serem atualizados';
        }
    }
    
    public function getListaArtigo(){
        $select = $this->_db->select()
                ->from($this->_name, array('key'=>'idMateria','value'=>'titulo'));
        $result = $this->getAdapter()->fetchAll($select);
        
        return $result;
    }


}

