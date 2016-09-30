<?php

namespace app\controller;

use sale\model\SaleItemDao;
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
        $limit = 30;
        View::renderPhp('list', [
            'list'  => $this->dao->query( $p, $limit ),
            'size'  => $this->dao->size(),
            'limit' => $limit,
            'page'  => $p,
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
