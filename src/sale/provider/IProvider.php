<?php
 

namespace sale\provider;

/**
 *
 * @author vench
 */
interface IProvider {
 
    /**
     * @return string Description
     */
    public function getName();
    
    /**
     * @return \sale\model\SaleItem[]
     */
    public function getAllSaleItem();
    
    /**
     * 
     * @param \sale\model\SaleItem $item
     * @return string Description
     */
    public function getItemDescription($item);
}
