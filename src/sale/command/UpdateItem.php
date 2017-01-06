<?php

namespace sale\command;

use app\ApplyAppableInterface;
use app\AppContextInterface;

class UpdateItem implements ApplyAppableInterface {

    /**
     *
     * @var \sale\dao\SaleItemDao 
     */
    private $dao;
    
    /**
     *
     * @var \sale\dao\SaleTagDao 
     */
    private $daoTag;

    /**
     *
     * @var \sale\dao\SaleTagItemDao 
     */
    private $daoTagItem;




    public function update($type) {
        
        $pid = new Pid($type);
        if(!$pid->open()) {
            echo "Error pid", PHP_EOL;
            return;
        }
        
        $dao = $this->dao;
        
        
        
        $provider = \sale\provider\Provider::getProvider($type);
        echo "Start: {$provider->getName()} \n";
        $old = $dao->getHashByType($provider->getName());

        foreach ($provider->getAllSaleItem() as $model) {
            echo $model->getTitle(), PHP_EOL, $model->getLink();

            if ($model->getPriceDiff() < 1) {
                continue;
            }

            if (isset($old[$model->getHash()])) {
                $model->setId($old[$model->getHash()]);
                unset($old[$model->getHash()]);
            }
            $dao->save($model);
            $this->makeTags($model);

            echo PHP_EOL, PHP_EOL;
        }

        if (!empty($old)) {
            $dao->deleteByIds($old);
        }
        
        $pid->close();
    }

    /**
     * 
     * @param app\AppContextInterface $app
     */
    public function appInit(AppContextInterface $app) {
        $this->dao = $app->get('sale\dao\SaleItemDao');
        $this->daoTag = $app->get('sale\dao\SaleTagDao');
        $this->daoTagItem = $app->get('sale\dao\SaleTagItemDao');
    }
    
    /**
     * 
     * @param \sale\model\SaleItem $model
     */
    private function makeTags(\sale\model\SaleItem $model) {
        $title = $model->getTitle();
        
        $titles  = preg_split('/\s/', $title);
        $tagTitle = '';
        foreach ($titles as $t) {
            $tagTitle .= $t;
            $len = $this->strlen($t); 
             
            if($len < 3 || 
               $this->substr($t, $len - 1) == '.' ||      
               in_array($this->substr($t, $len - 2), ['ая', 'ое', 'ой', 'ие', 'ые', 'ий','ый'])) {
                $tagTitle .= ' ';
                continue;
            }
            break;
            
        }
        
        $tagTitle = $this->tolower($tagTitle);
        
        if(!empty($tagTitle) && !is_null($tag = $this->getTagByTitle($tagTitle))) {
           $this->daoTagItem->addItemTag($model->getId(), $tag->getId());
        }
    }  
    
    /**
     * 
     * @staticvar array $hash
     * @staticvar array $hashTag
     * @param string $tagTitle
     * @return \sale\model\SaleTag
     */
    public function getTagByTitle($tagTitle) {
        
        static $hash = null;
        static $hashTag = [];
        
        $key = md5($tagTitle);
        
        if(isset($hashTag[$key])) {
            return $hashTag[$key];
        }
        
        if(is_null($hash)) { 
            $hash = $this->daoTag->getHashByMD5Title();
        }       
        
        $tag = new \sale\model\SaleTag();
        $tag->setTitle($tagTitle); 
        
        if(isset($hash[$key])) {
            $tag->setId($hash[$key]);
        } else {
            $this->daoTag->save($tag);
        }
         
        return $hashTag[$key] = $tag;
    }
    
    /**
     * 
     * @param string $str
     * @return string
     */
    private function strlen($str) {
        return function_exists('mb_strlen') ? mb_strlen($str) : strlen($str);
    }

    /**
     * 
     * @param string $str
     * @param int $start
     * @param int $length
     * @return string
     */
    private function substr($str, $start, $length = null) {
        return function_exists('mb_substr') ? mb_substr($str, $start, $length) : substr($str, $start, $length);
    }
    
    /**
     * 
     * @param string $str
     * @return string
     */
    private function tolower($str) {
        return function_exists('mb_strtolower') ?  mb_strtolower($str) : strtolower($str);
    }
}
