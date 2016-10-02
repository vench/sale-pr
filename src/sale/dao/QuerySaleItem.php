<?php

 namespace sale\dao;


/** 
*/
class QuerySaleItem {

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


	public function getCondition() {
		$params = [];
		$condition = '';
		$conditions = [];
		if(!empty($this->text)) {
			$conditions[] = 'title like :title';
			$params[':title'] = $this->text.'%';
		}
		if(!empty($this->saleSize)) {
			$conditions[] = 'price_diff >= :saleSize';
			$params[':saleSize'] = (int)$this->saleSize;
		}

		if(!empty($conditions)) {
			$condition = 'WHERE '.join('AND ', $conditions).'';
		}
		 
		return new Condition($condition, $params);
	}

	public function getParams() {
		$params = [];
		if(!empty($this->text)) {
			$params['text'] = $this->text;
		}
		if(!empty($this->saleSize)) {
			$params['saleSize'] = $this->saleSize;
		}

		return   empty($params) ? '' :  http_build_query(['f' => $params] );
	}
}


