<?php

namespace sale\model;

/**
 * Description of SaleItemPrice
 *
 * @author vench
 */
class SaleItemPrice {

    
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
    * @var int 
    */
   private $price;
   
   /**
    *
    * @var string 
    */
   private $date_insert;
   
   
   public function getId() {
       return $this->id;
   }

   public function getItemId() {
       return $this->item_id;
   }

   public function getPrice() {
       return $this->price;
   }

   public function getDateInsert() {
       return $this->date_insert;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function setItemId($item_id) {
       $this->item_id = $item_id;
   }

   public function setPrice($price) {
       $this->price = $price;
   }

   public function setDateInsert( $date_insert) {
       $this->date_insert = $date_insert;
   }


 
}
