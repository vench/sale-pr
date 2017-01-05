<?php
 

namespace sale\model;

/**
 * Description of SaleTagItem
 *
 * @author vench
 */
class SaleTagItem {
	/**
	*
	* @var int
	*/
	private $id;

	/**
	*
	* @var int
	*/
	private $tag_id;

	/**
	*
	* @var int
	*/
	private $item_id;

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
	public function getTagId() {
		return $this->tag_id;
	}

	/**
	*
	* @param $tag_id int
	*/
	public function setTagId($tag_id) {
		$this->tag_id = $tag_id;
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

}
