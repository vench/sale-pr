<?php
 

namespace sale\dao;

/**
 * Description of SaleTagDao
 *
 * @author vench
 */
class SaleTagDao {
    
    
    public function getHashByMD5Title() {
        $conn = $this->getConnection(); 
        $sql = 'SELECT id,title FROM sale_tag ';
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $hash = [];
        foreach ($rows as $row) {
            $key = md5($row['title']);
            $hash[$key] = $row['id'];
        }
        return $hash;
    }
    
    /**
     * 
     * @param int $offset
     * @param int $limit
     * @return \sale\model\SaleTag[]
     */
    public function query($offset = 0, $limit = 10) {
        $conn = $this->getConnection(); 
        $sql = 'SELECT * FROM sale_tag s ORDER BY s.order DESC '
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
     * @return \sale\model\SaleTag
     */
    public function get($id) {
        $conn = $this->getConnection();
        $sql = 'SELECT * FROM sale_tag WHERE id =:id';
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
     * @param \sale\model\SaleTag $model
     * @return booelan
     */
    public function save(\sale\model\SaleTag $model) {
        $conn = $this->getConnection();
        if(is_null($model->getId())) {
            $sql = 'INSERT INTO sale_tag (`parent_id`,`title`) '
                    . 'VALUES (:parent_id,:title)';
            $stmt = $conn->prepare($sql); 
            return $stmt->execute([  
		':parent_id' => $model->getParentId(),
		':title' => $model->gettitle(),
                    
                ]);
        }  
        $sql = 'UPDATE  sale_tag SET `parent_id`=:parent_id,`title`=:title WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([ 
		':id' => $model->getid(),
		':parent_id' => $model->getParentId(),
		':title' => $model->gettitle(),

        ]);
    }
    
    /**
     * 
     * @param \sale\model\SaleTag $model
     * @return boolean
     */
    public function delete(\sale\model\SaleTag $model) {
        $conn = $this->getConnection();
        $sql = 'DELETE FROM sale_tag WHERE id =:id';
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $model->getId()]);
    }

    /**
     * @return int Description
     */
    public function size() {
        $conn = $this->getConnection();
        $sql = 'SELECT COUNT(*) AS c FROM sale_tag';
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
     * @return \sale\model\SaleTag
     */
    private function fillModel(array $row) {
        $model = new \sale\model\SaleTag();
        foreach ($row as $key => $value) {
            $method = 'set' . ucfirst($key);
            if(method_exists($model, $method)) {
               call_user_func_array([$model, $method], [$value]); 
            }
        }
        return $model;
    } 
}
