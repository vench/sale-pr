<?php

 namespace sale\dao;

/**
 * Description of SaleItemDao
 *
 * @author vench
 */
class SaleItemDao {
    
    /**
     * 
     * @param string $type
     * @return array
     */
    public function getHashByType( $type ) {
        $conn = $this->getConnection(); 
        $sql = 'SELECT id,hash FROM sale_item WHERE host=:host'; 
        $stmt = $conn->prepare($sql);
        $stmt->execute([':host' => $type]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $res = [];
        if(is_array($rows)) {
            foreach ($rows as $row) {
                $res[$row['hash']] = $row['id'];
            } 
        }  
        return $res;
    }
    
    
    /**
     * 
     * @param int $tagId
     * @param int $limit
     * @param array $notItemIds
     * @return  sale\model\SaleItem[]
     */
    public function getItemsByTagId($tagId, $limit = 4, $notItemIds = null) {
        $q = new QuerySaleItem([
            'tag'           => $tagId,
            'limit'         => $limit,
            'notItemIds'    => $notItemIds
        ]);
        
        return $this->query($q);
    }

    /**
     * 
     * @param \sale\dao\QuerySaleItem $q
     * @return sale\model\SaleItem[]
     */
    public function query(QuerySaleItem $q) { 
	$condition = $q->getCondition(); 

 	$conn = $this->getConnection(); 
        $sql = 'SELECT * FROM sale_item '.$condition->getCondition() . ' ' . $condition->getOrder() 
                . ' LIMIT '. (int)$q->offset . ',' . (int)$q->limit; //var_dump( $sql ); exit();
        $stmt = $conn->prepare($sql);
        $stmt->execute($condition->getParams());
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(is_array($rows)) {
            $self = $this;
            return array_map(function($row) use(&$self){
                return $self->fillModel($row);
            }, $rows);  
        }         
        return [];

    }
    
     
    
    /**
     * 
     * @param int $id
     * @return sale\model\SaleItem
     */
    public function get($id) {
        $conn = $this->getConnection(); 
        $sql = 'SELECT * FROM sale_item WHERE id =:id';
        $stmt = $conn->prepare($sql);
        
        $stmt->execute([':id'=> $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return $this->fillModel($row);  
        } 
        return null;
    }
    
    /**
     * 
     * @param \sale\model\SaleItem $model
     * @return booelan
     */
    public function save(\sale\model\SaleItem $model) {
        $conn = $this->getConnection();
        if(is_null($model->getId())) {
            $sql = 'INSERT INTO sale_item (`title`,`image`,`price_old`,`price_new`,`link`,`hash`,`host`,`date_insert`,`price_diff`) '
                    . 'VALUES (:title,:image,:price_old,:price_new,:link,:hash,:host,:date_insert,:price_diff)';
            $stmt = $conn->prepare($sql); 
            return $stmt->execute([  
		':title' => $model->gettitle(),
		':image' => $model->getimage(),
		':price_old' => $model->getpriceOld(),
		':price_new' => $model->getpriceNew(),
		':link' => $model->getlink(),
		':hash' => $model->gethash(),
		':host' => $model->gethost(),
		':date_insert' => $model->getdateInsert(),
                ':price_diff'   => $model->getPriceDiff(),
                    
                ]);
        }  
        $sql = 'UPDATE  sale_item SET `title`=:title,`image`=:image,`price_old`=:price_old,`price_new`=:price_new,`link`=:link,`hash`=:hash,`host`=:host,`date_insert`=:date_insert,`price_diff`=:price_diff WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([ 
		':id' => $model->getid(),
		':title' => $model->gettitle(),
		':image' => $model->getimage(),
		':price_old' => $model->getpriceOld(),
		':price_new' => $model->getpriceNew(),
		':link' => $model->getlink(),
		':hash' => $model->gethash(),
		':host' => $model->gethost(),
		':date_insert' => $model->getdateInsert(),
                ':price_diff'   => $model->getPriceDiff(),

        ]);
    }
    
    /**
     * 
     * @param sale\model\SaleItem $model
     * @return boolean
     */
    public function delete(\app\model\SaleItem $model) {
        $conn = $this->getConnection();
        $sql = 'DELETE FROM sale_item WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $model->getId()]);
    }

    /**
    * @param int[] $ids
    * @return boolean
    */			
    public function deleteByIds( $ids ) { 
	$conn = $this->getConnection();
        $sql = 'DELETE FROM sale_item WHERE id IN ('.join(',', $ids).')';
        $stmt = $conn->prepare($sql);
        return $stmt->execute();
    }

    /**
     * @return int Description
     */
    public function size(QuerySaleItem $q) {

	$condition = $q->getCondition();

        $conn = $this->getConnection();
        $sql = 'SELECT COUNT(*) AS c FROM sale_item '.$condition->getCondition().'';
        $stmt = $conn->prepare($sql);
        
        $stmt->execute($condition->getParams());
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return isset($row['c']) ? $row['c'] : 0;
    }
            
    /**
     * 
     * @return \PDO
     */
    public function getConnection() {
        return \app\util\Connection::getConn();
    }
    
    /**
     * 
     * @return string
     */
    public function error() {
        $conn = $this->getConnection();
        return $conn->errorCode();
    }
    
    /**
     * 
     * @param array $row
     * @return sale\model\SaleItem
     */
    private function fillModel(array $row) {
        $model = new \sale\model\SaleItem();
        foreach ($row as $key => $value) {
	    $key = str_replace('_', '', $key);
            $method = 'set' . ucfirst($key);
            if(method_exists($model, $method)) {
               call_user_func_array([$model, $method], [$value]); 
            }
        }
        return $model;
    }     
}
