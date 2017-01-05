<?php


require_once dirname(__FILE__) . '/src/AutoLoad.php';  
AutoLoad::init();


echo app\util\Model::echoDao('sale_tag', '\sale\model\SaleTag');