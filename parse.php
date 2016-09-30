<?php

require_once dirname(__FILE__) . '/src/AutoLoad.php';  

AutoLoad::init();


$p = new sale\html\DOMParser('<div class="labels-content">
		 <img src="x"/><span>mets</span></div>');
$n = $p->parse();

var_dump($n);

