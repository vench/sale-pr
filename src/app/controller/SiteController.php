<?php

namespace app\controller;

use sale\model\SaleItemDao;
use sale\dao\QuerySaleItem;
use app\ApplyAppableInterface;
use app\AppContextInterface;
use app\util\View;

/**
 * Description of HomeController
 *
 * @author vench
 */
class SiteController implements ApplyAppableInterface {
    
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
     * @var Request
     */
    private $request; 
    
    /**
     *
     * @var \sale\dao\SaleItemInfoDao 
     */
    private $itemInfoDao;
    
    /**
     *
     * @var \sale\dao\SaleItemPriceDao
     */
    private $daoPriceItem;


    /**
     * 
     * @param int $p
     */
    public function actionIndex($p = 0) { 
         
        $filterData =  isset($_GET['f']) ? $_GET['f'] : []; 
	$q = new  QuerySaleItem($filterData);
	$q->limit = 30;
	$q->offset = $p;
        
        $tag = NULL;
        if(!empty($q->tagId)) {
            $tag = $this->daoTag->get($q->tagId);
        }
        
        //var_dump($this->dao->deleteByIds([1,2,]));
        
        View::renderPhp('list', [
            'list'  => $this->dao->query( $q ),
            'size'  => $this->dao->size( $q ), 
	    'q'     => $q,	
            'tag'   => $tag,
            'tags'  => $this->daoTag->query(0, 30),
        ]); 
    }

    /**
     * 
     */
    public function actionTags() {
        
        $tags = $this->daoTag->query(0, 10000);
        
        usort($tags, function($a, $b){
            return $a->getTitle() <=> $b->getTitle();
        });
        
        View::renderPhp('tags', [ 
            'tags'  => $tags,
        ]);
    }
    
    /**
     * 
     * @param type $id
     * @return string
     */
    public function actionDetail($id) { 
	$item = $this->dao->get( $id );
	if(is_null($item)) {
		return "";
	}	
        
        
        //TODO to lazy pack
        
        $itemInfo = $this->itemInfoDao->getByItemId($id);
        if(is_null($itemInfo)) {
            $itemInfo = new \sale\model\SaleItemInfo();
            $itemInfo->setItemId($id);
            
            $provider = \sale\provider\Provider::getProvider( $item->getHost() );
            $itemInfo->setText(   $provider->getItemDescription($item) );
            
            $this->itemInfoDao->save($itemInfo);
        } 
        
        $tags = $this->daoTag->getTagByItem($item);
           
        
        
        View::renderPhp('item', [
            'item'  => $item,
            'tags'  => $tags,
            'description'   => $itemInfo->getText(),
            'relatedItems'       => isset($tags[0]) ? 
                $this->dao->getItemsByTagId( $tags[0]->getId(), 4, [$id] ) : [],
            'prices'    => $this->daoPriceItem->getByItemId($id),
        ]); 
     }
     
     
     public function actionAbout() {
         View::renderPhp('about', [
             
        ]);
     }
    
 

    /**
     * 
     * @param app\AppContextInterface $app
     */
    public function appInit(AppContextInterface $app) {
        $this->dao = $app->get('sale\dao\SaleItemDao');
        $this->daoTag = $app->get('sale\dao\SaleTagDao');
        $this->request = $app->get('app\Request');
        $this->itemInfoDao  = $app->get('sale\dao\SaleItemInfoDao');
        $this->daoPriceItem = $app->get('sale\dao\SaleItemPriceDao');
    }

}
