<?php
 

namespace sale\dao;

/**
 * Description of SaleItemInfoDao
 *
 * @author vench
 */
class SaleItemInfoDao {
    
    /**
     * 
     * @param int $itemId
     * @return \sale\model\SaleItemInfo
     */
    public function getByItemId($itemId) {
        $conn = $this->getConnection();
        $sql = 'SELECT * FROM sale_item_info WHERE item_id =:itemId';
        $stmt = $conn->prepare($sql);
        
        $stmt->execute([':itemId'=> $itemId]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return $this->fillModel($row);  
        } 
        return null;
    }

    /**
     * 
     * @param int $offset
     * @param int $limit
     * @return \sale\model\SaleItemInfo[]
     */
    public function query($offset = 0, $limit = 10) {
        $conn = $this->getConnection(); 
        $sql = 'SELECT * FROM sale_item_info '
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
     * @param int $id
     * @return \sale\model\SaleItemInfo
     */
    public function get($id) {
        $conn = $this->getConnection();
        $sql = 'SELECT * FROM sale_item_info WHERE id =:id';
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
     * @param \sale\model\SaleItemInfo $model
     * @return booelan
     */
    public function save(\sale\model\SaleItemInfo $model) {
        $conn = $this->getConnection();
        if(is_null($model->getId())) {
            $sql = 'INSERT INTO sale_item_info (`item_id`,`text`) '
                    . 'VALUES (:item_id,:text)';
            $stmt = $conn->prepare($sql); 
            return $stmt->execute([  
		':item_id' => $model->getItemId(),
		':text' => $model->gettext(),
                    
                ]);
        }  
        $sql = 'UPDATE  sale_item_info SET `item_id`=:item_id,`text`=:text WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([ 
		':id' => $model->getid(),
		':item_id' => $model->getItemId(),
		':text' => $model->gettext(),

        ]);
    }
    
    /**
     * 
     * @param \sale\model\SaleItemInfo $model
     * @return boolean
     */
    public function delete(\sale\model\SaleItemInfo $model) {
        $conn = $this->getConnection();
        $sql = 'DELETE FROM sale_item_info WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $model->getId()]);
    }

    /**
     * @return int Description
     */
    public function size() {
        $conn = $this->getConnection();
        $sql = 'SELECT COUNT(*) AS c FROM sale_item_info';
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
    * @param int[] $ids
    * @return boolean
    */			
    public function deleteByItemIds( $ids ) { 
	$conn = $this->getConnection();
        $sql = 'DELETE FROM sale_item_info WHERE item_id IN ('.join(',', $ids).')';
        $stmt = $conn->prepare($sql);
        return $stmt->execute();
    }
    
    
    /**
     * 
     * @param array $row
     * @return \sale\model\SaleItemInfo
     */
    private function fillModel(array $row) {
        $model = new \sale\model\SaleItemInfo();
        foreach ($row as $key => $value) {
            $method = 'set' . ucfirst($key);
            if(method_exists($model, $method)) {
               call_user_func_array([$model, $method], [$value]); 
            }
        }
        return $model;
    }  
}
