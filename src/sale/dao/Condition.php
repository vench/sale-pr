<?php


 namespace sale\dao;

/**
 * 
 */
class Condition {

	private $condition;

	private $params;
        
        private $order;

        /**
         * 
         * @param string $condition
         * @param array $params
         * @param string $order
         */
        public function __construct($condition = '', $params = [], $order = '') {
		$this->params = $params;
		$this->condition = $condition;
                $this->order = $order;
	}

        /**
         * 
         * @return string
         */
	public function getParams() {
		return $this->params;
	}

        /**
         * 
         * @return string
         */
	public function getCondition() {
		return  $this->condition;
	}
        
        /**
         * 
         * @return string
         */
        public function getOrder() {
		return  $this->order;
	}
}
