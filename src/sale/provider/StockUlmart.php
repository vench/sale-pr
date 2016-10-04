<?php 

namespace sale\provider;

/**
 * Description of StockUlmart
 *
 * @author vench
 */
class StockUlmart extends Provider {
 
    public function getAllSaleItem() {
        $baseUrl = 'https://stock.ulmart.ru/stock/saleAdditional?sort=5&viewType=1&destination=&extended=&filters=&numericFilters=&brands=&jdSuppliers=&warranties=&bargainTypes=&priceColors=&receiptTime=&minWarranty=&maxWarranty=&shops=&labels=&available=&reserved=&suborder=&availableCounts=&superPrice=&showCrossboardGoods=&showUlmartGoods=&specOffers=&minPrice=&maxPrice=&query=&pageNum=1';
        $html = file_get_contents($baseUrl);
        $p = new \sale\html\DOMParser($html);
        $n = $p->parse();
        
        $ns = \sale\html\Find::find2($n, 'section.b-product');
        foreach($ns as $node) {
            
            $title = \sale\html\Find::find($node, '.b-product__descr');
            
            
            var_dump($title); exit();
        }
        return [];
    }

}
