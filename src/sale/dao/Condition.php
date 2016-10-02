<?php


 namespace sale\dao;


class Condition {

	private $condition;

	private $params;

	public function __construct($condition = '', $params = []) {
		$this->params = $params;
		$this->condition = $condition;
	}

	public function getParams() {
		return $this->params;
	}

	public function getCondition() {
		return  $this->condition;
	}
}
