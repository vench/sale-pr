<?php
 

namespace sale\model;

/**
 * Description of SaleItemInfo
 *
 * @author vench
 */
class SaleItemInfo {
	/**
	*
	* @var int
	*/
	private $id;

	/**
	*
	* @var int
	*/
	private $item_id;

	/**
	*
	* @var string
	*/
	private $text;

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
	public function getItemId() {
		return $this->item_id;
	}

	/**
	*
	* @param $item_id int
	*/
	public function setItemId($item_id) {
		$this->item_id = $item_id;
	}

	/**
	*
	* @return string
	*/
	public function getText() {
		return $this->text;
	}

	/**
	*
	* @param $text string
	*/
	public function setText($text) {
		$this->text = $text;
	}


}
