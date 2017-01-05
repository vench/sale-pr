<?php


require_once dirname(__FILE__) . '/src/AutoLoad.php';  
AutoLoad::init();


//echo app\util\Model::echoTableModel('sale_tag_item');

echo app\util\Model::echoDao('sale_tag_item', '\sale\model\SaleTagItem');