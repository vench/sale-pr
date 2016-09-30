<?php

require_once dirname(__FILE__) . '/src/AutoLoad.php';  

AutoLoad::init();
 

$app = \app\App::current();
$dao = $app->get('sale\dao\SaleItemDao');

$provider = \sale\provider\Provider::getProvider( \sale\provider\Provider::TYPE_MVIDEO );

echo "Start: {$provider->getName()} \n";

$old = $dao->getHash();

foreach ($provider->getAllSaleItem() as $model) {
    echo $model->getTitle(), PHP_EOL, $model->getLink();
    
    if(isset($old[$model->getHash()])) {
        $model->setId($old[$model->getHash()]);
    }
    $dao->save($model); 
   
    echo PHP_EOL, PHP_EOL; 
}

 
