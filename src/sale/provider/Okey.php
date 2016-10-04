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
            $n = $p->parse();
            $ns = \sale\html\Find::find($n, '.product_price');
            foreach($ns as $node) {
                $top = $node->getParent();
                if(!is_null($top)) { 
                    $price = \sale\html\Find::find2($top, 'span > span.price'); 
                    $crossed = \sale\html\Find::find2($top, 'span > span.label.small.crossed');
                    $title = \sale\html\Find::find($top, '.product_name'); 
                    
                    print_r($crossed); print_r( $top); exit();
                }    
            }
        }
        
        
        
            
        
        return [];
    }

}
