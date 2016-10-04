<?php 

namespace sale\provider;

/**
 * Description of StockUlmart
 *
 * @author vench
 */
class StockUlmart extends Provider {
 
    public function getAllSaleItem() {
        
        $baseUrl = 'https://stock.ulmart.ru/stock/saleAdditional?sort=5&viewType=1&destination=&extended=&filters=&numericFilters=&brands=&jdSuppliers=&warranties=&bargainTypes=&priceColors=&receiptTime=&minWarranty=&maxWarranty=&shops=&labels=&available=&reserved=&suborder=&availableCounts=&superPrice=&showCrossboardGoods=&showUlmartGoods=&specOffers=&minPrice=&maxPrice=&query=&pageNum=';
        
        
        for($i = 1; $i < (300); $i ++) {
            $url = $baseUrl . $i;
            $html = file_get_contents($url);

            $p = new \sale\html\DOMParser($html);
            $n = $p->parse(true);

            $ns = \sale\html\Find::find2($n, 'section.b-product');

            foreach($ns as $node) {

                $title = \sale\html\Find::find2($node, 'div.b-product__descr', true);
                $prices = \sale\html\Find::find2($node, 'span.b-price__num', true);
                $link =  \sale\html\Find::find2($node, 'i.must_be_href', true); 
                $img = \sale\html\Find::find2($node, 'span > img', true);  


                if(isset($title[0]) && count($prices) == 2 && isset($link[0])) { 

                    $url = 'http://'. $this->getName() . $link[0]->getAttribute('title');
                    $hash = md5($url);
                    $model = new \sale\model\SaleItem();
                    $model->setHash($hash);
                    $model->setTitle($title[0]->getData());
                    $model->setPriceOld(intval( $prices[0]->getData() ));
                    $model->setPriceNew(intval( $prices[1]->getData()));
                    $model->setLink( $url );
                    $model->setDateInsert(date('Y-m-d H:i'));
                    $model->setHost($this->getName());
                    $model->setImage( isset($img[0])  ? $img[0]->getAttribute('src') : null);
                    $model->setPriceDiff(   ( 1 - $model->getPriceNew() / $model->getPriceOld()) * 100  );

                    yield $model;
                } 
            } 
        }
    }

}
