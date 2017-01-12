<?php

require_once dirname(__FILE__) . '/src/AutoLoad.php';  
AutoLoad::init();
 

$app = \app\App::current();
$comm = $app->get('sale\command\UpdateItem');
$comm->update(\sale\provider\Provider::TYPE_ELDORADO);