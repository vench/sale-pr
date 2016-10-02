<?php

 namespace sale\dao;


/**
* TODO rename to QueryItemDao ~
*/
class Query {

	public $offset = 0;

	public $limit = 10;

	public $text;

	public $saleSize;

	public function __construct($params = []) { 
		foreach($params as $field => $value) {
			if($field == 'text') {
				$this->text = $value;	
			}
			if($field == 'saleSize') {
				$this->saleSize = $value;	
			}
		}
	}
}
