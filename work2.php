<?php

require_once dirname(__FILE__) . '/src/AutoLoad.php';  

AutoLoad::init();
 

$provider = \sale\provider\Provider::getProvider( \sale\provider\Provider::TYPE_MVIDEO );

var_dump($provider->getAllSaleItem());