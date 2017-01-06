<?php
 

namespace sale\model;

/**
 * Description of SaleTag
 *
 * @author vench
 */
class SaleTag {
	/**
	*
	* @var int
	*/
	private $id;

	/**
	*
	* @var int
	*/
	private $parent_id;

	/**
	*
	* @var string
	*/
	private $title;
        
        /**
         *
         * @var int
         */
        private $order;

	/**
	*
	* @return int
	*/
	public function getId() {
		return $this->id;
	}

	/**
	*
	* @param $id int
	*/
	public function setId($id) {
		$this->id = $id;
	}

	/**
	*
	* @return int
	*/
	public function getParentId() {
		return $this->parent_id;
	}

	/**
	*
	* @param $parent_id int
	*/
	public function setParentId($parent_id) {
		$this->parent_id = $parent_id;
	}

	/**
	*
	* @return string
	*/
	public function getTitle() {
		return $this->title;
	}

	/**
	*
	* @param $title string
	*/
	public function setTitle($title) {
		$this->title = $title;
	}

        /**
         * 
         * @return int
         */
        public function getOrder() {
            return $this->order;
        }

        /**
         * 
         * @param int $order
         */
        public function setOrder($order) {
            $this->order = $order;
        }


}
