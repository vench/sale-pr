<?php
 

namespace sale\dao;

/**
 * Description of SaleTagItemDao
 *
 * @author vench
 */
class SaleTagItemDao {
    
    public function addItemTag($itemId, $tagId) {
        if(is_null($itemId) || is_null($tagId)) {
            return null;
        }
        
        $model = new \sale\model\SaleTagItem();
        $model->setItemId($itemId);
        $model->setTagId($tagId);
        return $this->save($model);
    }
    
    
 /**
     * 
     * @param int $offset
     * @param int $limit
     * @return \sale\model\SaleTagItem[]
     */
    public function query($offset = 0, $limit = 10) {
        $conn = $this->getConnection(); 
        $sql = 'SELECT * FROM sale_tag_item '
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
     * @return \sale\model\SaleTagItem
     */
    public function get($id) {
        $conn = $this->getConnection();
        $sql = 'SELECT * FROM sale_tag_item WHERE id =:id';
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
     * @param \sale\model\SaleTagItem $model
     * @return booelan
     */
    public function save(\sale\model\SaleTagItem $model) {
        $conn = $this->getConnection();
        if(is_null($model->getId())) {
            $sql = 'INSERT IGNORE INTO sale_tag_item (`tag_id`,`item_id`) '
                    . 'VALUES (:tag_id,:item_id)';
            $stmt = $conn->prepare($sql); 
            return $stmt->execute([  
		':tag_id' => $model->getTagId(),
		':item_id' => $model->getItemId(),
                    
                ]);
        }  
        $sql = 'UPDATE  sale_tag_item SET `tag_id`=:tag_id,`item_id`=:item_id WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([ 
		':id' => $model->getid(),
		':tag_id' => $model->gettagid(),
		':item_id' => $model->getItemId(),

        ]);
    }
    
    /**
     * 
     * @param \sale\model\SaleTagItem $model
     * @return boolean
     */
    public function delete(\sale\model\SaleTagItem $model) {
        $conn = $this->getConnection();
        $sql = 'DELETE FROM sale_tag_item WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $model->getId()]);
    }

    /**
     * @return int Description
     */
    public function size() {
        $conn = $this->getConnection();
        $sql = 'SELECT COUNT(*) AS c FROM sale_tag_item';
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
     * @return \sale\model\SaleTagItem
     */
    private function fillModel(array $row) {
        $model = new \sale\model\SaleTagItem();
        foreach ($row as $key => $value) {
            $method = 'set' . ucfirst($key);
            if(method_exists($model, $method)) {
               call_user_func_array([$model, $method], [$value]); 
            }
        }
        return $model;
    }  
}
