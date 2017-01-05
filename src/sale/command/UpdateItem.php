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

    public function update($type) {
        $dao = $this->dao;
        $daoTag = $this->daoTag;
        
        
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

            echo PHP_EOL, PHP_EOL;
        }

        if (!empty($old)) {
            $dao->deleteByIds($old);
        }
    }

    /**
     * 
     * @param app\AppContextInterface $app
     */
    public function appInit(AppContextInterface $app) {
        $this->dao = $app->get('sale\dao\SaleItemDao');
        $this->daoTag = $app->get('sale\dao\SaleTagDao');
    }

}
