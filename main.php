<?php


require_once dirname(__FILE__) . '/src/AutoLoad.php';  
AutoLoad::init();


//echo app\util\Model::echoTableModel('sale_item_info');

echo app\util\Model::echoDao('sale_item_info', '\sale\model\SaleItemInfo');