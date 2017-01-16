<?php
 

namespace sale\controller;

/**
 * Description of ApiController
 *
 * @author vench
 */
class ApiController implements \app\ApplyAppableInterface {
    
    
    /**
     *
     * @var \sale\dao\SaleItemDao 
     */
    private $dao;


    /**
     * 
     * @param type $p
     */
    public function actionIndex($p = 0) { 
        
        
        $q = new \sale\dao\QuerySaleItem();
        $q->limit = 10;
        $q->offset = $p * $q->limit;
        
        $size = $this->dao->size($q);
        if($size < $q->offset) {
            return [];
        }
        $rows = $this->dao->query($q);
        
        
        
        $helperFunstions = \app\util\View::getHelperFunstions();
        
        \app\util\View::renderJSON(array_map(function($n) use(&$helperFunstions) {
            return [
                'id'         => $n->getId() + 100000,
                'real_id'    => $n->getId(),
                'type'       => 'item',   
                'title'      => $n->getTitle(),
                'url'        => 'http://bcost.ru/?a=site/detail&id=' . $n->getId(),
                'descpript'  => $n->getTitle()  . ' за ' . $helperFunstions['priceFormat']($n->getPriceNew()),
                'image'      => $n->getImage(),
                'video'      => null,   
            ];
        }, $rows), true, true);
        
    }
    
    /**
     * 
     * @param \app\AppContextInterface $app
     * @todo Description
     */
    public function appInit(\app\AppContextInterface $app) {
        $this->dao = $app->get('sale\dao\SaleItemDao');
    }

}
