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
     * @var Request
     */
    private $request; 


    /**
     * 
     * @param int $p
     */
    public function actionIndex($p = 0) { 
         
        $filterData =  isset($_GET['f']) ? $_GET['f'] : []; 
	$q = new  QuerySaleItem($filterData);
	$q->limit = 30;
	$q->offset = $p;
        View::renderPhp('list', [
            'list'  => $this->dao->query( $q ),
            'size'  => $this->dao->size( $q ), 
	    'q'		=> $q,	
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
        View::renderPhp('item', [
            'item'  => $item,
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
        $this->request = $app->get('app\Request');
    }

}
