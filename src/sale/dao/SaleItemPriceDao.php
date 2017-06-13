<?php


namespace sale\dao;

/**
 * Description of SaleItemPriceDao
 *
 * @author vench
 */
class SaleItemPriceDao {

    /**
     * 
     * @param int $offset
     * @param int $limit
     * @return \sale\model\SaleItemPrice[]
     */
    public function query($offset = 0, $limit = 10) {
        $conn = $this->getConnection(); 
        $sql = 'SELECT * FROM sale_item_price '
                . 'LIMIT '. (int)$offset . ',' . (int)$limit; 
        $stmt = $conn->prepare($sql);
        $stmt->execute();
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
     * @param int $offset
     * @param int $limit
     * @return \sale\model\SaleItemPrice[]
     */
    public function getByItemId($itemId) {
        $conn = $this->getConnection(); 
        $sql = 'SELECT * FROM sale_item_price WHERE item_id =:item_id';
        $stmt = $conn->prepare($sql);
        
        $stmt->execute([':item_id'=> $itemId]);
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
     * @return \sale\model\SaleItemPrice
     */
    public function get($id) {
        $conn = $this->getConnection();
        $sql = 'SELECT * FROM sale_item_price WHERE id =:id';
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
     * @param \sale\model\SaleItemPrice $model
     * @return booelan
     */
    public function save(\sale\model\SaleItemPrice $model) {
        $conn = $this->getConnection();
        if(is_null($model->getId())) {
            $sql = 'INSERT INTO sale_item_price (`item_id`,`price`,`date_insert`) '
                    . 'VALUES (:item_id,:price,:date_insert)';
            $stmt = $conn->prepare($sql); 
            return $stmt->execute([  
		':item_id' => $model->getItemId(),
		':price' => $model->getPrice(),
		':date_insert' => $model->getDateInsert(),
                    
                ]);
        }  
        $sql = 'UPDATE  sale_item_price SET `item_id`=:item_id,`price`=:price,`date_insert`=:date_insert WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([ 
		':id' => $model->getid(),
		':item_id' => $model->getitem_id(),
		':price' => $model->getprice(),
		':date_insert' => $model->getdate_insert(),

        ]);
    }
    
    /**
     * 
     * @param \sale\model\SaleItemPrice $model
     * @return boolean
     */
    public function delete(\sale\model\SaleItemPrice $model) {
        $conn = $this->getConnection();
        $sql = 'DELETE FROM sale_item_price WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $model->getId()]);
    }

    /**
     * @return int Description
     */
    public function size() {
        $conn = $this->getConnection();
        $sql = 'SELECT COUNT(*) AS c FROM sale_item_price';
        $stmt = $conn->prepare($sql);
        
        $stmt->execute();
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
     * @param array $row
     * @return \sale\model\SaleItemPrice
     */
    private function fillModel(array $row) {
        $model = new \sale\model\SaleItemPrice();
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
