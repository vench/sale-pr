<?php
 

namespace sale\provider;

/**
 * Description of Okey
 *
 * @author vench
 */
class Okey extends Provider {
    
    public function getAllSaleItem() {
        $url= 'https://www.okeydostavka.ru/msk/skidki-38055-20/produkty-38056-20';
        
        $html = file_get_contents($url);
        if(strpos($html, 'product_price') !== false) {
            $p = new \sale\html\DOMParser($html);
            $n = $p->parse(true);
            $ns = \sale\html\Find::find2($n, 'div.product.ok-theme');
            
            
        
            foreach($ns as $node) {
                 
                 $price = \sale\html\Find::find2($node, 'span.product_price'); 
                
                    var_dump($price); exit();    
            }
        }
        
        
        
            
        
        return [];
    }

}
