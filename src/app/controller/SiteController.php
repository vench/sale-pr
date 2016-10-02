<?php

namespace app\controller;

use sale\model\SaleItemDao;
use sale\dao\Query;
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
     * @var Request
     */
    private $request; 


    /**
     * 
     * @param int $p
     */
    public function actionIndex($p = 0) { 
         
        $filterData =  isset($_GET['f']) ? $_GET['f'] : []; 
	$q = new  Query($filterData);
	$q->limit = 30;
	$q->offset = $p;
        View::renderPhp('list', [
            'list'  => $this->dao->query2( $q ),
            'size'  => $this->dao->size(),
            'limit' => $q->limit,
            'page'  => $q->offset,
	    'q'		=> $q,	
        ]); 
    }

    public function actionDetail($id) { 
	$item = $this->dao->get( $id );
	if(is_null($item)) {
		return "";
	}	
View::renderPhp('item', [
            'item'  => $item,
        ]);
     }
    
 

    /**
     * 
     * @param app\AppContextInterface $app
     */
    public function appInit(AppContextInterface $app) {
        $this->dao = $app->get('sale\dao\SaleItemDao');
        $this->request = $app->get('app\Request');
    }

}
