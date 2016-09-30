<?php

 namespace sale\model;

/**
 * Description of SaleItem
 *
 * @author vench
 */
class SaleItem {
	/**
	*
	* @var int
	*/
	private $id;

	/**
	*
	* @var string
	*/
	private $title;

	/**
	*
	* @var string
	*/
	private $image;

	/**
	*
	* @var int
	*/
	private $price_old;

	/**
	*
	* @var int
	*/
	private $price_new;

	/**
	*
	* @var string
	*/
	private $link;

	/**
	*
	* @var string
	*/
	private $hash;

	/**
	*
	* @var string
	*/
	private $host;

	/**
	*
	* @var string
	*/
	private $date_insert;
        
        /**
         *
         * @var int
         */
        private $price_diff;

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
	* @return string
	*/
	public function getImage() {
		return $this->image;
	}

	/**
	*
	* @param $image string
	*/
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	*
	* @return int
	*/
	public function getPriceOld() {
		return $this->price_old;
	}

	/**
	*
	* @param $price_old int
	*/
	public function setPriceOld($price_old) {
		$this->price_old = $price_old;
	}

	/**
	*
	* @return int
	*/
	public function getPriceNew() {
		return $this->price_new;
	}
        
        /**
         * 
         * @return int
         */
        public function getPriceDiff() {
                return $this->price_diff;
        }
        
        /**
         * 
         * @param int $price_diff
         */
        public function setPriceDiff($price_diff) {
                $this->price_diff = $price_diff;
        }

	/**
	*
	* @param $price_new int
	*/
	public function setPriceNew($price_new) {
		$this->price_new = $price_new;
	}

	/**
	*
	* @return string
	*/
	public function getLink() {
		return $this->link;
	}

	/**
	*
	* @param $link string
	*/
	public function setLink($link) {
		$this->link = $link;
	}

	/**
	*
	* @return string
	*/
	public function getHash() {
		return $this->hash;
	}

	/**
	*
	* @param $hash string
	*/
	public function setHash($hash) {
		$this->hash = $hash;
	}

	/**
	*
	* @return string
	*/
	public function getHost() {
		return $this->host;
	}

	/**
	*
	* @param $host string
	*/
	public function setHost($host) {
		$this->host = $host;
	}

	/**
	*
	* @return string
	*/
	public function getDateInsert() {
		return $this->date_insert;
	}

	/**
	*
	* @param $date_insert string
	*/
	public function setDateInsert($date_insert) {
		$this->date_insert = $date_insert;
	}

}
